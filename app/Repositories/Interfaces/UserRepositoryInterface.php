<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use App\Models\User;

interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * Get all authors pending verification.
     * @return Collection
     */
    public function getAuthorsForVerification(): Collection;

    /**
     * Verify an author.
     * @param User $user
     * @return bool
     */
    public function verifyAuthor(User $user): bool;
}
