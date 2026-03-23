<?php

namespace App\Repositories\Eloquent;

use App\Enums\VoteType;
use App\Models\Post;
use App\Models\Vote;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    /**
     * PostRepository constructor.
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        parent::__construct($post);
    }

    /**
     * Get all posts with pagination.
     * @param int $perPage
     * @param int|null $userId
     * @param bool $trashed
     * @return LengthAwarePaginator
     */
    public function getAllPaginated(int $perPage = 10, ?int $userId = null, bool $trashed = false): LengthAwarePaginator
    {
        $query = $this->model->with([Post::REL_AUTHOR, Post::REL_MEDIA]);

        if ($trashed) {
            $query->onlyTrashed();
        }

        if ($userId) {
            $query->where(Post::COL_USER_ID, $userId);
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Get latest posts with pagination.
     * @param int $perPage
     * @param int|null $userId
     * @param bool $trashed
     * @return LengthAwarePaginator
     */
    public function getLatestWithPagination(int $perPage = 10, ?int $userId = null, bool $trashed = false): LengthAwarePaginator
    {
        return $this->getAllPaginated($perPage, $userId, $trashed);
    }

    /**
     * Find a record by ID.
     * @param int $id
     * @param bool $withTrashed
     * @return Model|null
     */
    public function find(int $id, bool $withTrashed = false): ?Model
    {
        $query = $this->model->with([Post::REL_AUTHOR, Post::REL_MEDIA]);

        if ($withTrashed) {
            $query->withTrashed();
        }

        return $query->find($id);
    }

    /**
     * Find a post by its ID.
     * @param int $id
     * @param bool $withTrashed
     * @return Post|null
     */
    public function findById(int $id, bool $withTrashed = false): ?Post
    {
        return $this->find($id, $withTrashed);
    }

    /**
     * Find a post by its slug.
     * @param string $slug
     * @return Post|null
     */
    public function findBySlug(string $slug): ?Post
    {
        return $this->model->with([Post::REL_AUTHOR, Post::REL_MEDIA])->where(Post::COL_SLUG, $slug)->first();
    }

    /**
     * Create a new post.
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update an existing post.
     * @param Model $post
     * @param array $data
     * @return bool
     */
    public function update(Model $post, array $data): bool
    {
        return $post->update($data);
    }

    /**
     * Restore a post.
     * @param Post|Model $post
     * @return bool
     */
    public function restore(Post|Model $post): bool
    {
        return $post->restore();
    }

    /**
     * Permanently delete a post.
     * @param Post|Model $post
     * @return bool
     */
    public function forceDelete(Post|Model $post): bool
    {
        return $post->forceDelete();
    }

    /**
     * Vote for a post.
     * @param Post $post
     * @param int|null $userId
     * @param VoteType $type
     * @param string|null $ipAddress
     * @param string|null $userAgent
     * @return void
     */
    public function vote(Post $post, ?int $userId, VoteType $type, ?string $ipAddress = null, ?string $userAgent = null): void
    {
        $attributes = [
            Vote::COL_USER_ID => $userId,
            Vote::COL_POST_ID => $post->{Post::COL_ID},
        ];

        if (!$userId) {
            $attributes[Vote::COL_IP_ADDRESS] = $ipAddress;
        }

        $post->votes()->updateOrCreate(
            $attributes,
            [
                Vote::COL_TYPE => $type,
                Vote::COL_USER_AGENT => $userAgent
            ]
        );
    }
}
