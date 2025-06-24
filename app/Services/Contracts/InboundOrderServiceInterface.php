<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface InboundOrderServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Model;
    public function create(array $data): Model;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function receiveItems(int $orderId, array $itemsData): bool;
}
