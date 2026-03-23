<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface RepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface RepositoryInterface
{
    /**
     * Get all records.
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Get all records with pagination.
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 10): LengthAwarePaginator;

    /**
     * Find a record by ID.
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model;

    /**
     * Create a new record.
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model;

    /**
     * Update an existing record.
     * @param Model $model
     * @param array $data
     * @return bool
     */
    public function update(Model $model, array $data): bool;

    /**
     * Delete a record.
     * @param Model $model
     * @return bool
     */
    public function delete(Model $model): bool;
}
