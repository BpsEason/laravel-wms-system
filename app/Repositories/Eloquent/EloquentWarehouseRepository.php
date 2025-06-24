<?php

namespace App\Repositories\Eloquent;

use App\Models\${MODEL_NAME};
use App\Repositories\Contracts\${ENTITY}RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Eloquent${ENTITY}Repository implements ${ENTITY}RepositoryInterface
{
    protected $model;

    public function __construct(${MODEL_NAME} $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $model = $this->model->find($id);
        if ($model) {
            return $model->update($data);
        }
        return false;
    }

    public function delete(int $id): bool
    {
        $model = $this->model->find($id);
        if ($model) {
            return $model->delete();
        }
        return false;
    }
}
