<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Services\Interfaces\PostServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class PostService implements PostServiceInterface
{
    protected PostRepositoryInterface $repository;

    public function __construct(PostRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all posts with pagination.
     * @param int $perPage
     * @param int|null $userId
     * @param bool $trashed
     * @return LengthAwarePaginator
     */
    public function getAllPosts(int $perPage = 10, ?int $userId = null, bool $trashed = false): LengthAwarePaginator
    {
        return $this->repository->getLatestWithPagination($perPage, $userId, $trashed);
    }

    /**
     * Restore a deleted post.
     * @param int $id
     * @return bool
     */
    public function restorePost(int $id): bool
    {
        $post = $this->repository->findById($id, true);
        if ($post) {
            return $this->repository->restore($post);
        }
        return false;
    }

    /**
     * Permanently delete a post.
     * @param int $id
     * @return bool
     */
    public function forceDeletePost(int $id): bool
    {
        $post = $this->repository->findById($id, true);
        if ($post) {
            return $this->repository->forceDelete($post);
        }
        return false;
    }

    /**
     * Create a new post.
     * @param array $data
     * @param \App\Models\User|null $user
     * @param \Illuminate\Http\UploadedFile|null $image
     * @return Post
     */
    public function createPost(array $data, ?\App\Models\User $user = null, ?\Illuminate\Http\UploadedFile $image = null): Post
    {
        if ($user) {
            $data[Post::COL_USER_ID] = $user->{User::COL_ID};
        }

        $post = $this->repository->create($data);

        if ($image) {
            $post->addMedia($image)->toMediaCollection(Post::MEDIA_COLLECTION_IMAGES);
        }

        return $post;
    }

    /**
     * Update an existing post.
     * @param Post $post
     * @param array $data
     * @param \Illuminate\Http\UploadedFile|null $image
     * @return bool
     */
    public function updatePost(Post $post, array $data, ?\Illuminate\Http\UploadedFile $image = null): bool
    {
        $updated = $this->repository->update($post, $data);

        if ($updated && $image) {
            $post->clearMediaCollection(Post::MEDIA_COLLECTION_IMAGES);
            $post->addMedia($image)->toMediaCollection(Post::MEDIA_COLLECTION_IMAGES);
        }

        return $updated;
    }

    /**
     * Delete a post.
     * @param Post $post
     * @return bool
     */
    public function deletePost(Post $post): bool
    {
        return $this->repository->delete($post);
    }

    /**
     * Get a single post with relationships.
     * @param Post $post
     * @return Post
     */
    public function getPost(Post $post): Post
    {
        return $post->load([Post::REL_AUTHOR, Post::REL_MEDIA])->append(['likes_count', 'dislikes_count']);
    }

    /**
     * Vote for a post.
     * @param Post $post
     * @param int|null $userId
     * @param \App\Enums\VoteType $type
     * @param string|null $ipAddress
     * @param string|null $userAgent
     * @return void
     */
    public function votePost(Post $post, ?int $userId, \App\Enums\VoteType $type, ?string $ipAddress = null, ?string $userAgent = null): void
    {
        $this->repository->vote($post, $userId, $type, $ipAddress, $userAgent);
    }
}
