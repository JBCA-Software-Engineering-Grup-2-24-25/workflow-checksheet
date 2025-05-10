<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role->permissions->where('route', 'roles.index')->count() > 0;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Role $role): bool
    {
        return $user->role->permissions->where('route', 'roles.show')->count() > 0;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role->permissions->where('route', 'roles.store')->count() > 0;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Role $role): bool
    {
        return $user->role->permissions->whereIn('route', ['roles.update', 'superadmin'])->count() > 0 && $role->author_id === $user->id && $role->name !== 'Super Admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Role $role): bool
    {
        $role->loadCount('users');
        return $user->role->permissions->whereIn('route', ['roles.destroy', 'superadmin'])->count() > 0 && $role->author_id === $user->id && $role->deleteable;
    }
}
