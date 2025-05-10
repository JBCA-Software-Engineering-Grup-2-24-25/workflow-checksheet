<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role->permissions->where('route', 'users.index')->count() > 0;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->role->permissions->where('route', 'users.show')->count() > 0;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role->permissions->where('route', 'users.store')->count() > 0;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {

        return $user->role->permissions->where('route', 'superadmin')->count() > 0
            || ($user->role->permissions->where('route', 'users.update')->count() > 0 && $model->author_id === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->role->permissions->where('route', 'superadmin')->count() > 0
            || ($user->role->permissions->where('route', 'users.destroy')->count() > 0 && $model->author_id === $user->id);
    }
}
