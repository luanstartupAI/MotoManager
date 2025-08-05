<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CustomerPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, string $permission): bool
    {
        return parent::viewAny($user, $permission);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, $model, string $permission): bool
    {
        return parent::view($user, $model, $permission);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, string $permission): bool
    {
        return parent::create($user, $permission);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, $model, string $permission): bool
    {
        return parent::update($user, $model, $permission);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, $model, string $permission): bool
    {
        return parent::delete($user, $model, $permission);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, $model, string $permission): bool
    {
        return parent::restore($user, $model, $permission);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, $model, string $permission): bool
    {
        return parent::forceDelete($user, $model, $permission);
    }
}

