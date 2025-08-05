<?php

namespace App\Policies;

use App\Models\Motorcycle;
use App\Models\User;

class MotorcyclePolicy extends BasePolicy
{
    public function viewAny(User $user, string $permission): bool
    {
        return parent::viewAny($user, $permission);
    }

    public function view(User $user, $model, string $permission): bool
    {
        return parent::view($user, $model, $permission);
    }

    public function create(User $user, string $permission): bool
    {
        return parent::create($user, $permission);
    }

    public function update(User $user, $model, string $permission): bool
    {
        return parent::update($user, $model, $permission);
    }

    public function delete(User $user, $model, string $permission): bool
    {
        return parent::delete($user, $model, $permission);
    }

    public function restore(User $user, $model, string $permission): bool
    {
        return parent::restore($user, $model, $permission);
    }

    public function forceDelete(User $user, $model, string $permission): bool
    {
        return parent::forceDelete($user, $model, $permission);
    }
}

