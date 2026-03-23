<?php

namespace App\Services\Interfaces;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

interface PostServiceInterface
{
    /**
     * Get all posts with pagination.
     * @param int $perPage
     * @param int|null $userId
     * @param bool $trashed
     * @return LengthAwarePaginator
     */
    public function getAllPosts(int $perPage = 10, ?int $userId = null, bool $trashed = false): LengthAwarePaginator;

    public function restorePost(int $id): bool;

    public function forceDeletePost(int $id): bool;

    /**
     * Create a new post.
     * @param array $data
     * @param \App\Models\User|null $user
     * @param \Illuminate\Http\UploadedFile|null $image
     * @return Post
     */
    public function createPost(array $data, ?\App\Models\User $user = null, ?\Illuminate\Http\UploadedFile $image = null): Post;

    /**
     * Update an existing post.
     * @param Post $post
     * @param array $data
     * @param \Illuminate\Http\UploadedFile|null $image
     * @return bool
     */
    public function updatePost(Post $post, array $data, ?\Illuminate\Http\UploadedFile $image = null): bool;

    public function deletePost(Post $post): bool;

    public function getPost(Post $post): Post;

    public function votePost(Post $post, ?int $userId, \App\Enums\VoteType $type, ?string $ipAddress = null, ?string $userAgent = null): void;
}
