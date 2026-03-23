<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class UserService implements UserServiceInterface
{
    protected UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get authors for verification.
     * @return Collection
     */
    public function getAuthorsForVerification(): Collection
    {
        return $this->repository->getAuthorsForVerification();
    }

    /**
     * Update the user's profile information.
     * @param User $user
     * @param array $data
     * @return bool
     */
    public function updateProfile(User $user, array $data): bool
    {
        $user->fill($data);

        if ($user->isDirty(User::COL_EMAIL)) {
            $user->{User::COL_EMAIL_VERIFIED_AT} = null;
        }

        return $user->save();
    }

    /**
     * Delete a user's account.
     * @param User $user
     * @return bool
     */
    public function deleteAccount(User $user): bool
    {
        return $user->delete();
    }

    /**
     * Verify an author.
     * @param User $user
     * @return bool
     */
    public function verifyAuthor(User $user): bool
    {
        return $this->repository->verifyAuthor($user);
    }
}
