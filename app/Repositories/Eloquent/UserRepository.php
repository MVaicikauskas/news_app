<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Enums\UserRole;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    /**
     * Get all authors pending verification.
     * @return Collection
     */
    public function getAuthorsForVerification(): Collection
    {
        return User::role(UserRole::AUTHOR->value)
            ->with('roles')
            ->whereNotNull(User::COL_EMAIL_VERIFIED_AT)
            ->orderBy(User::COL_IS_VERIFIED_BY_ADMIN, 'asc')
            ->orderBy(User::COL_CREATED_AT, 'desc')
            ->get();
    }

    /**
     * Verify an author.
     * @param User $user
     * @return bool
     */
    public function verifyAuthor(User $user): bool
    {
        return $user->update([
            User::COL_IS_VERIFIED_BY_ADMIN => true,
            User::COL_ADMIN_VERIFIED_AT => now(),
        ]);
    }
}
