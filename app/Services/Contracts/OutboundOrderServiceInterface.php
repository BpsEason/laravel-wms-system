<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface OutboundOrderServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Model;
    public function create(array $data): Model;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function pickItems(int $orderId, array $itemsData): bool;
    public function shipOrder(int $orderId, array $shippingData): bool;
}
