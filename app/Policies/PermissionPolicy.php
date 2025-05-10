<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;

class PermissionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role->permissions->where('route', 'permission.index')->count() > 0;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Permission $permission): bool
    {
        return $user->role->permissions->whereIn('route', ['permission.update', 'superadmin'])->count() > 0 && $permission->route !== 'superadmin';
    }
}
