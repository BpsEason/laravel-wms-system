<?php

namespace App\Services\Implementations;

use App\Services\Contracts\${SERVICE_NAME}ServiceInterface;
use App\Repositories\Contracts\${REPO_INTERFACE};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ${SERVICE_NAME}Service implements ${SERVICE_NAME}ServiceInterface
{
    protected $repository;

    public function __construct(${REPO_INTERFACE} $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(): Collection
    {
        return $this->repository->all();
    }

    public function getById(int $id): ?Model
    {
        return $this->repository->find($id);
    }

    public function create(array $data): Model
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->repository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
