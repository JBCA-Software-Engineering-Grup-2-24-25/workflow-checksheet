<?php

namespace App\Http\Controllers\Role;

use App\Http\Requests\Permission\PermissionRequest;
use App\Interfaces\Permission\PermissionInterface;
use App\Interfaces\Role\RoleInterface;
use App\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PermissionController extends BaseController
{
    public function __construct(RoleInterface $role, PermissionInterface $permission)
    {
        parent::__construct($role, $permission);

        $this->setSortChoices([
            'created_at-asc' => 'Oldest',
            'created_at-desc' => 'Newest',
            'name-desc' => 'Z-A',
            'name-asc' => 'A-Z',
        ]);
    }

    public function index(Request $request) : View
    {
        $this->setSearch($request);
        $this->setPagination($request);
        $this->setSort($request);

        $data = $this->permission->GetPaginatePermission(
            search: $this->search,
            perPage: $this->pageSize,
            currentPage: $this->page,
            sortBy: $this->sortBy,
            sortDirection: $this->sortDirection
        );

        return view('permission.index', [
            'data' => $data,
            'search' => $this->search,
            'sortChoices' => $this->sortChoices,
            'sortBy' => $this->sortBy . '-' . $this->sortDirection,
        ]);
    }

    public function edit(Permission $permission) : View
    {
        return view('permission.manage', ['data' => $permission]);
    }

    public function update(PermissionRequest $request, Permission $permission) : RedirectResponse
    {
        $this->permission->UpdatePermission($request, $permission);

        return redirect()->route('permission.index')->with('status', 'permission-updated');
    }
}
