<?php

namespace App\Services\Implementations;

use App\Services\Contracts\InboundOrderServiceInterface;
use App\Repositories\Contracts\InboundOrderRepositoryInterface;
use App\Repositories\Contracts\InboundItemRepositoryInterface;
use App\Repositories\Contracts\InventoryRepositoryInterface;
use App\Models\InboundOrder;
use App\Models\InboundItem;
use App\Models\Inventory;
use App\Events\InboundOrderCompleted;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

class InboundOrderService implements InboundOrderServiceInterface
{
    protected $inboundOrderRepository;
    protected $inboundItemRepository;
    protected $inventoryRepository;

    public function __construct(
        InboundOrderRepositoryInterface $inboundOrderRepository,
        InboundItemRepositoryInterface $inboundItemRepository,
        InventoryRepositoryInterface $inventoryRepository
    ) {
        $this->inboundOrderRepository = $inboundOrderRepository;
        $this->inboundItemRepository = $inboundItemRepository;
        $this->inventoryRepository = $inventoryRepository;
    }

    public function getAll(): Collection
    {
        return $this->inboundOrderRepository->all();
    }

    public function getById(int $id): ?Model
    {
        return $this->inboundOrderRepository->find($id);
    }

    public function create(array $data): Model
    {
        return $this->inboundOrderRepository->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->inboundOrderRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->inboundOrderRepository->delete($id);
    }

    /**
     * Receives items for a given inbound order.
     *
     * @param int $orderId
     * @param array $itemsData ['item_id' => int, 'received_quantity' => int, 'target_location_id' => int]
     * @return bool
     * @throws Exception
     */
    public function receiveItems(int $orderId, array $itemsData): bool
    {
        $order = $this->inboundOrderRepository->find($orderId);

        if (!$order) {
            throw new Exception("Inbound Order not found.");
        }

        if ($order->status !== 'pending') {
            throw new Exception("Only pending orders can be received.");
        }

        DB::beginTransaction();
        try {
            foreach ($itemsData as $itemData) {
                $inboundItem = $this->inboundItemRepository->find($itemData['item_id']);

                if (!$inboundItem || $inboundItem->inbound_order_id !== $orderId) {
                    throw new Exception("Inbound item not found or does not belong to this order.");
                }

                $receivedQuantity = $itemData['received_quantity'];
                $targetLocationId = $itemData['target_location_id'];

                if ($receivedQuantity <= 0) {
                    throw new Exception("Received quantity must be positive.");
                }

                if ($receivedQuantity > ($inboundItem->expected_quantity - $inboundItem->received_quantity)) {
                    throw new Exception("Received quantity exceeds expected quantity for item ID: " . $inboundItem->id);
                }

                // Update inbound item received quantity and target location
                $this->inboundItemRepository->update($inboundItem->id, [
                    'received_quantity' => $inboundItem->received_quantity + $receivedQuantity,
                    'target_location_id' => $targetLocationId,
                ]);

                // Update or create inventory
                $inventory = Inventory::firstOrNew([
                    'product_id' => $inboundItem->product_id,
                    'location_id' => $targetLocationId,
                ]);

                $inventory->quantity += $receivedQuantity;
                $inventory->save();
            }

            // Check if all items are fully received
            $allItemsReceived = $order->items->every(function ($item) {
                return $item->received_quantity >= $item->expected_quantity;
            });

            if ($allItemsReceived) {
                $this->inboundOrderRepository->update($orderId, ['status' => 'received']);
                event(new InboundOrderCompleted($order));
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
