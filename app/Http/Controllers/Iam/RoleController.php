<?php

namespace App\Http\Controllers\Iam;

use App\Http\Requests\Iam\RoleRequest;
use App\Interfaces\Iam\PermissionInterface;
use App\Interfaces\Iam\RoleInterface;
use App\Interfaces\Iam\UserInterface;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends BaseController
{
    public function __construct(UserInterface $user, RoleInterface $role, PermissionInterface $permission)
    {
        parent::__construct($user, $role, $permission);

        $this->setSortChoices([
            'created_at-asc' => 'Oldest',
            'created_at-desc' => 'Newest',
            'name-desc' => 'Z-A',
            'name-asc' => 'A-Z',
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : View
    {
        $this->setSearch($request);
        $this->setPagination($request);
        $this->setSort($request);

        $data = $this->role->GetPaginatedRole(
            search: $this->search,
            perPage: $this->pageSize,
            currentPage: $this->page,
            sortBy: $this->sortBy,
            sortDirection: $this->sortDirection
        );

        return view('role.index', [
            'data' => $data,
            'search' => $this->search,
            'sortChoices' => $this->sortChoices,
            'sortBy' => $this->sortBy . '-' . $this->sortDirection
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $permissions = $this->permission->GetAllPermission();
        return view('role.manage', ['permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request) : RedirectResponse
    {
        $this->role->CreateRole($request);

        return redirect()->route('roles.index')->with('status', 'role-user-created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role) : View
    {
        $permissions = $this->permission->GetAllPermission();
        $data = $this->role->GetRole($role);

        return view('role.detail', ['data' => $data, 'permissions' => $permissions]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role) : View
    {
        $permissions = $this->permission->GetAllPermission();
        $data = $this->role->GetRole($role);
        return view('role.manage', ['data' => $data, 'permissions' => $permissions]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role) : RedirectResponse
    {
        $this->role->UpdateRole($request, $role);

        return redirect()->route('roles.index')->with('status', 'role-user-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role) : RedirectResponse
    {
        $this->authorize('roles.destroy', $role);

        $this->role->DeleteRole($role);

        return redirect()->route('roles.index')->with('status', 'role-user-deleted');
    }

    public function searchRole(Request $request) : JsonResponse
    {
        $this->setSearch($request);

        $roles = $this->role->GetRoleBySearch($this->search);

        return response()->json(['message' => 'success', 'data' => $roles]);
    }
}
