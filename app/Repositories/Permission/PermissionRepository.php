<?php

namespace App\Repositories;

use App\Http\Requests\Permission\PermissionRequest;
use App\Interfaces\Permission\PermissionInterface;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class PermissionRepository implements PermissionInterface
{
    public function GetPaginatePermission(string $search, string $sortBy, string $sortDirection, int $perPage = 10, int $currentPage = 1)
    {
        $collection = Permission::query()
            ->when(!empty($search), fn (Builder $query) => $query->where('name', 'like', '%'. strtolower($search) . '%')->orWhere('route', 'like', '%'. strtolower($search) . '%'))
            ->when(! empty($sortBy) && ! empty($sortDirection), fn (Builder $query) => $query->orderBy($sortBy, $sortDirection))
            ->when(empty($sortBy) && empty($sortDirection), fn (Builder $query) => $query->oldest())
            ->paginate(perPage: $perPage, page: $currentPage);

        return $collection;
    }

    public function GetAllPermission() : Collection
    {
        return Permission::query()
            ->select('*',
                DB::raw('SUBSTRING_INDEX(route, ".", 1) as prefix_route'),
            )
            ->where('route', '!=', 'superadmin')
            ->orderBy('route')
            ->get()
            ->filter(function ($permission) {
                return !$permission->IsDefault && !$permission->IsDefaultAllowed;
            })
            ->sortBy([['is_default', 'desc'], ['prefix_route', 'asc']])
            ->groupBy('prefix_route');
    }

    public function UpdatePermission(PermissionRequest $request, Permission $permission)
    {
        $data = $request->validated();
        $permission->update($data);
    }
}
