<?php

namespace App\Interfaces\Role;

use App\Http\Requests\Role\RoleRequest;
use App\Http\Resources\Role\RoleResource;
use App\Models\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface RoleInterface
{
    public function GetPaginatedRole(string $search, string $sortBy, string $sortDirection, int $perPage = 10, int $currentPage = 1) : LengthAwarePaginator;
    public function GetAllRole() : Collection;
    public function CreateRole(RoleRequest $request) : RoleResource;
    public function GetRole(Role $role);
    public function UpdateRole(RoleRequest $request, Role $role) : RoleResource;
    public function DeleteRole(Role $role) : void;
    public function NeedApproval(int $roleId) : bool;
    public function GetRoleBySearch(string $search) : array;
    public function GetRoleById(int $id) : array;
    public function GetInitialRole() : array;
}
