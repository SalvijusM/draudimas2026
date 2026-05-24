<?php

namespace App\Policies;

use App\Models\Owner;
use App\Models\User;

class OwnerPolicy
{
    public function before(User $user, string $ability)
    {
        if ($user->role === 'admin') {
            return true;
        }
    }

    public function viewAny(User $user): bool
    {
        return $user->role === 'viewer' || $user->role === 'admin';
    }

    public function view(User $user, Owner $owner): bool
    {
        return $user->role === 'viewer' || $user->id === $owner->user_id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Owner $owner): bool
    {
        return $user->id === $owner->user_id;
    }

    public function delete(User $user, Owner $owner): bool
    {
        return $user->id === $owner->user_id;
    }
}
