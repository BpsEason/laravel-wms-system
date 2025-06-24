<?php

namespace App\Services\Implementations;

use App\Services\Contracts\OutboundOrderServiceInterface;
use App\Repositories\Contracts\OutboundOrderRepositoryInterface;
use App\Repositories\Contracts\OutboundItemRepositoryInterface;
use App\Repositories\Contracts\InventoryRepositoryInterface;
use App\Repositories\Contracts\ShippingLogRepositoryInterface;
use App\Models\OutboundOrder;
use App\Models\OutboundItem;
use App\Models\Inventory;
use App\Events\OutboundOrderShipped;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

class OutboundOrderService implements OutboundOrderServiceInterface
{
    protected $outboundOrderRepository;
    protected $outboundItemRepository;
    protected $inventoryRepository;
    protected $shippingLogRepository;

    public function __construct(
        OutboundOrderRepositoryInterface $outboundOrderRepository,
        OutboundItemRepositoryInterface $outboundItemRepository,
        InventoryRepositoryInterface $inventoryRepository,
        ShippingLogRepositoryInterface $shippingLogRepository
    ) {
        $this->outboundOrderRepository = $outboundOrderRepository;
        $this->outboundItemRepository = $outboundItemRepository;
        $this->inventoryRepository = $inventoryRepository;
        $this->shippingLogRepository = $shippingLogRepository;
    }

    public function getAll(): Collection
    {
        return $this->outboundOrderRepository->all();
    }

    public function getById(int $id): ?Model
    {
        return $this->outboundOrderRepository->find($id);
    }

    public function create(array $data): Model
    {
        return $this->outboundOrderRepository->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->outboundOrderRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->outboundOrderRepository->delete($id);
    }

    /**
     * Picks items for an outbound order.
     *
     * @param int $orderId
     * @param array $itemsData ['item_id' => int, 'picked_quantity' => int, 'source_location_id' => int]
     * @return bool
     * @throws Exception
     */
    public function pickItems(int $orderId, array $itemsData): bool
    {
        $order = $this->outboundOrderRepository->find($orderId);

        if (!$order) {
            throw new Exception("Outbound Order not found.");
        }

        if ($order->status !== 'pending') {
            throw new Exception("Only pending orders can be picked.");
        }

        DB::beginTransaction();
        try {
            foreach ($itemsData as $itemData) {
                $outboundItem = $this->outboundItemRepository->find($itemData['item_id']);

                if (!$outboundItem || $outboundItem->outbound_order_id !== $orderId) {
                    throw new Exception("Outbound item not found or does not belong to this order.");
                }

                $pickedQuantity = $itemData['picked_quantity'];
                $sourceLocationId = $itemData['source_location_id'];

                if ($pickedQuantity <= 0) {
                    throw new Exception("Picked quantity must be positive.");
                }

                if ($pickedQuantity > ($outboundItem->requested_quantity - $outboundItem->picked_quantity)) {
                    throw new Exception("Picked quantity exceeds requested quantity for item ID: " . $outboundItem->id);
                }

                // Find the inventory item
                $inventory = Inventory::where('product_id', $outboundItem->product_id)
                                    ->where('location_id', $sourceLocationId)
                                    ->first();

                if (!$inventory || $inventory->quantity < $pickedQuantity) {
                    throw new Exception("Insufficient stock for product ID {$outboundItem->product_id} at location ID {$sourceLocationId}. Available: " . ($inventory->quantity ?? 0) . ", Requested: {$pickedQuantity}");
                }

                // Update inventory
                $inventory->quantity -= $pickedQuantity;
                $inventory->save();

                // Update outbound item picked quantity and source location
                $this->outboundItemRepository->update($outboundItem->id, [
                    'picked_quantity' => $outboundItem->picked_quantity + $pickedQuantity,
                    'source_location_id' => $sourceLocationId,
                ]);
            }

            // Check if all items are fully picked
            $allItemsPicked = $order->items->every(function ($item) {
                return $item->picked_quantity >= $item->requested_quantity;
            });

            if ($allItemsPicked) {
                $this->outboundOrderRepository->update($orderId, ['status' => 'picked']);
            } else {
                // If some items are picked but not all, set status to partially_picked
                $this->outboundOrderRepository->update($orderId, ['status' => 'partially_picked']);
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Ships an outbound order.
     *
     * @param int $orderId
     * @param array $shippingData ['tracking_number' => string, 'carrier' => string]
     * @return bool
     * @throws Exception
     */
    public function shipOrder(int $orderId, array $shippingData): bool
    {
        $order = $this->outboundOrderRepository->find($orderId);

        if (!$order) {
            throw new Exception("Outbound Order not found.");
        }

        if (!in_array($order->status, ['picked', 'partially_picked'])) {
            throw new Exception("Only picked or partially picked orders can be shipped.");
        }

        DB::beginTransaction();
        try {
            // Update order status to shipped
            $this->outboundOrderRepository->update($orderId, ['status' => 'shipped']);

            // Create shipping log
            $shippingData['outbound_order_id'] = $orderId;
            $shippingData['shipped_at'] = now();
            $this->shippingLogRepository->create($shippingData);

            event(new OutboundOrderShipped($order, $shippingData));

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
