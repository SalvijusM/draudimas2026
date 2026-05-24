<?php

namespace App\Policies;

use App\Models\Car;
use App\Models\User;

class CarPolicy
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

    public function view(User $user, Car $car): bool
    {
        return $user->role === 'viewer' || ($car->owner && $user->id === $car->owner->user_id);
    }

    public function create(User $user): bool
    {
        return $user->role !== 'viewer'; // Viewer negali kurti
    }

    public function update(User $user, Car $car): bool
    {
        return $car->owner && $user->id === $car->owner->user_id;
    }

    public function delete(User $user, Car $car): bool
    {
        return $car->owner && $user->id === $car->owner->user_id;
    }
}
