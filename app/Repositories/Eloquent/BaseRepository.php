<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class BaseRepository
 * @package App\Repositories\Eloquent
 */
abstract class BaseRepository implements RepositoryInterface
{
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * BaseRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all records.
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * Get all records with pagination.
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    /**
     * Find a record by ID.
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Create a new record.
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update an existing record.
     * @param Model $model
     * @param array $data
     * @return bool
     */
    public function update(Model $model, array $data): bool
    {
        return $model->update($data);
    }

    /**
     * Delete a record.
     * @param Model $model
     * @return bool
     */
    public function delete(Model $model): bool
    {
        return $model->delete();
    }
}
