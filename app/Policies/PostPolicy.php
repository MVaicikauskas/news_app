<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     *  Determine whether the user can view the model.
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function view(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function update(User $user, Post $post): bool
    {
        if ($user->hasRole(\App\Enums\UserRole::ADMIN->value)) {
            return true;
        }

        return $user->{User::COL_ID} === $post->{Post::COL_USER_ID};
    }

    /**
     * Determine whether the user can delete the model.
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function delete(User $user, Post $post): bool
    {
        if ($user->hasRole(\App\Enums\UserRole::ADMIN->value)) {
            return true;
        }

        return $user->{User::COL_ID} === $post->{Post::COL_USER_ID};
    }

    /**
     * Determine whether the user can restore the model.
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function restore(User $user, Post $post): bool
    {
        if ($user->hasRole(\App\Enums\UserRole::ADMIN->value)) {
            return true;
        }

        return $user->{User::COL_ID} === $post->{Post::COL_USER_ID};
    }

    /**
     * Determine whether the user can permanently delete the model.
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function forceDelete(User $user, Post $post): bool
    {
        if ($user->hasRole(\App\Enums\UserRole::ADMIN->value)) {
            return true;
        }

        return $user->{User::COL_ID} === $post->{Post::COL_USER_ID};
    }
}
