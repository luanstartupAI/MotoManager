<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, string $permission): bool
    {
        return $user->can($permission);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, $model, string $permission): bool
    {
        return $user->can($permission);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, string $permission): bool
    {
        return $user->can($permission);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, $model, string $permission): bool
    {
        return $user->can($permission);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, $model, string $permission): bool
    {
        return $user->can($permission);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, $model, string $permission): bool
    {
        return $user->can($permission);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, $model, string $permission): bool
    {
        return $user->can($permission);
    }
}

