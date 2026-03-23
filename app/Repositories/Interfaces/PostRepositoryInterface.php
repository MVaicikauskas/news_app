<?php

namespace App\Repositories\Interfaces;

use App\Enums\VoteType;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface extends RepositoryInterface
{
    /**
     * Get all posts with pagination.
     * @param int $perPage
     * @param int|null $userId
     * @param bool $trashed
     * @return LengthAwarePaginator
     */
    public function getAllPaginated(int $perPage = 10, ?int $userId = null, bool $trashed = false): LengthAwarePaginator;

    /**
     * Get latest posts with pagination.
     * @param int $perPage
     * @param int|null $userId
     * @param bool $trashed
     * @return LengthAwarePaginator
     */
    public function getLatestWithPagination(int $perPage = 10, ?int $userId = null, bool $trashed = false): LengthAwarePaginator;

    /**
     * Find a post by its ID.
     * @param int $id
     * @param bool $withTrashed
     * @return Post|null
     */
    public function findById(int $id, bool $withTrashed = false): ?Post;

    /**
     * Restore a deleted post.
     * @param Post $post
     * @return bool
     */
    public function restore(Post $post): bool;

    /**
     * Permanently delete a post.
     * @param Post $post
     * @return bool
     */
    public function forceDelete(Post $post): bool;

    /**
     * Find a post by its slug.
     * @param string $slug
     * @return Post|null
     */
    public function findBySlug(string $slug): ?Post;

    /**
     * Vote for a post.
     * @param Post $post
     * @param int|null $userId
     * @param VoteType $type
     * @param string|null $ipAddress
     * @param string|null $userAgent
     * @return void
     */
    public function vote(Post $post, ?int $userId, VoteType $type, ?string $ipAddress = null, ?string $userAgent = null): void;
}
