<?php

namespace App\Repositories\Role;

use App\Http\Requests\Role\RoleRequest;
use App\Http\Resources\Role\RoleResource;
use App\Interfaces\Role\RoleInterface;
use App\Models\Permission;
use App\Models\Role;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleRepository implements RoleInterface
{
    public function __construct(private Role $model)
    {
    }

    public function GetAllRole() : Collection
    {
        return $this->model->query()->get();
    }

    public function GetPaginatedRole(string $search, string $sortBy, string $sortDirection, int $perPage = 10, int $currentPage = 1) : LengthAwarePaginator
    {
        return $this->model::query()
            ->when(!empty($search), fn (Builder $query) => $query->where(DB::raw('lower(name)'), 'like', '%'. strtolower($search) . '%'))
            ->withCount('users')
            ->when(! empty($sortBy) && ! empty($sortDirection), fn (Builder $query) => $query->orderBy($sortBy, $sortDirection))
            ->when(empty($sortBy) && empty($sortDirection), fn (Builder $query) => $query->oldest())
            ->paginate(perPage: $perPage, page: $currentPage);
    }

    public function CreateRole(RoleRequest $request): RoleResource
    {
        $data = $request->validated();
        $data['author_id'] = Auth::user()->id;
        $permissions = $data['permissions'];
        unset($data['permissions']);

        $role = DB::transaction(function () use ($data, $permissions) {
            /** @var Role $role */
            $role = $this->model->query()->create($data);

            // sync permissions including the allowed permissions because that id is not in the request
            $permissionsAllowed = Permission::query()
                ->where('route', '!=', 'superadmin')
                ->get()
                ->filter(function ($permission) {
                    return $permission->IsDefault || $permission->IsDefaultAllowed;
                })
                ->pluck('id')->toArray();

            $allPermissions = array_unique(array_merge($permissions, $permissionsAllowed));

            $role->permissions()->sync($allPermissions);

            return $role;
        });

        return new RoleResource($role);
    }

    public function GetRole(Role $role)
    {
        $role->loadMissing('permissions');
        $role->permissions = $role->permissions->sortBy([['is_default', 'desc'], ['route_prefix', 'asc']]);
        return $role;
    }

    public function UpdateRole(RoleRequest $request, Role $role): RoleResource
    {
        $data = $request->validated();
        $permissions = $data['permissions'];
        unset($data['permissions']);

        $role = DB::transaction(function () use ($role, $data, $permissions) {
            $role->update($data);

            // sync permissions including the allowed permissions because that id is not in the request
            $permissionsAllowed = Permission::query()
                ->where('route', '!=', 'superadmin')
                ->get()
                ->filter(function ($permission) {
                    return $permission->IsDefault || $permission->IsDefaultAllowed;
                })
                ->pluck('id')->toArray();

            $allPermissions = array_unique(array_merge($permissions, $permissionsAllowed));

            $role->permissions()->sync($allPermissions);

            return $role;
        });

        return new RoleResource($role);
    }

    public function DeleteRole(Role $role): void
    {
        $role->loadCount('users');
        if ($role->deleteable) {
            $role->delete();
        }
        else {
            throw new Exception(message: 'Role cannot be deleted.', code: 400);
        }
    }

    public function NeedApproval(int $roleId) : bool
    {
        $role = $this->model->query()
            ->where('id', '=', $roleId)
            ->where('need_approval', '=', true)
            ->first();

        if(!empty($role)) return true;

        return false;
    }

    public function GetRoleBySearch(string $search) : array
    {
        return $this->model->query()
            ->where(DB::raw('lower(name)'), 'like', '%' . strtolower($search) . '%')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($model) {
                return [
                    'label' => $model->name,
                    'value' => $model->id
                ];
            })
            ->toArray();
    }

    public function GetRoleById(int $id) : array
    {
        /** @var Role $role */
        $role = $this->model->query()
            ->where('id', '=', $id)
            ->first();

        if ($role === null) {
            return [];
        }

        return [
            'label' => $role->name,
            'value' => $role->id,
            'selected' => true,
        ];
    }

    public function GetInitialRole() : array
    {
        return $this->model->query()
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($model) {
                return [
                    'label' => $model->name,
                    'value' => $model->id
                ];
            })
            ->toArray();
    }
}
