<?php

namespace App\Services\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserServiceInterface
{
    /**
     * Get authors for verification.
     * @return Collection
     */
    public function getAuthorsForVerification(): Collection;

    /**
     * Update the user's profile information.
     * @param User $user
     * @param array $data
     * @return bool
     */
    public function updateProfile(User $user, array $data): bool;

    /**
     * Delete a user's account.
     * @param User $user
     * @return bool
     */
    public function deleteAccount(User $user): bool;
}
