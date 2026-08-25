<?php

namespace App\Policies;

use App\Models\Rental;
use App\Models\User;

class RentalPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view rentals');
    }

    public function view(User $user, Rental $rental): bool
    {
        if ($user->hasPermissionTo('view rentals') && $user->hasRole('admin')) {
            return true;
        }
        return $rental->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create rentals');
    }

    public function update(User $user, Rental $rental): bool
    {
        if ($user->hasPermissionTo('edit rentals') && $user->hasRole('admin')) {
            return true;
        }
        // Users can only update their own pending/confirmed rentals
        return $rental->user_id === $user->id
            && in_array($rental->status, ['pending']);
    }

    public function cancel(User $user, Rental $rental): bool
    {
        if ($user->hasPermissionTo('cancel rentals') && $user->hasRole('admin')) {
            return true;
        }
        return $rental->user_id === $user->id
            && in_array($rental->status, ['pending', 'confirmed']);
    }

    public function confirm(User $user, Rental $rental): bool
    {
        return $user->hasPermissionTo('confirm rentals');
    }

    public function delete(User $user, Rental $rental): bool
    {
        return $user->hasPermissionTo('delete rentals');
    }
}
