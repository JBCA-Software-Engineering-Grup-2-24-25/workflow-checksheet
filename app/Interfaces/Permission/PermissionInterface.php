<?php

namespace App\Interfaces\Permission;

use App\Http\Requests\Permission\PermissionRequest;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;

interface PermissionInterface
{
    public function GetPaginatePermission(string $search, string $sortBy, string $sortDirection, int $perPage = 10, int $currentPage = 1);
    public function GetAllPermission() : Collection;
    public function UpdatePermission(PermissionRequest $request, Permission $permission);
}
