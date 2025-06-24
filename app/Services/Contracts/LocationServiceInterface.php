<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ${SERVICE_NAME}ServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Model;
    public function create(array $data): Model;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
