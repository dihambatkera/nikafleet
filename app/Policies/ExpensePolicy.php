<?php

namespace App\Policies;

use App\Models\Expense;
use App\Models\User;

class ExpensePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view expenses');
    }

    public function view(User $user, Expense $expense): bool
    {
        return $user->hasPermissionTo('view expenses');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create expenses');
    }

    public function update(User $user, Expense $expense): bool
    {
        return $user->hasPermissionTo('edit expenses');
    }

    public function delete(User $user, Expense $expense): bool
    {
        return $user->hasPermissionTo('delete expenses');
    }
}
