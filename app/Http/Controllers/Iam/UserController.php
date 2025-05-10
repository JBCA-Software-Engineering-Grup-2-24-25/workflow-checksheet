<?php

namespace App\Http\Controllers\Iam;

use App\Http\Requests\Iam\UserRequest;
use App\Interfaces\Iam\PermissionInterface;
use App\Interfaces\Iam\RoleInterface;
use App\Interfaces\Iam\UserInterface;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends BaseController
{
    public function __construct(UserInterface $user, RoleInterface $role, PermissionInterface $permission)
    {
        parent::__construct($user, $role, $permission);

        $this->setSortChoices([
            'created_at-desc' => 'Newest',
            'created_at-asc' => 'Oldest',
            'name-desc' => 'Z-A',
            'name-asc' => 'A-Z',
            'last_seen-desc' => 'Last Seen (Newest)',
            'last_seen-asc' => 'Last Seen (Oldest)'
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

        $data = $this->user->GetPaginatedUser(
            search: $this->search,
            perPage: $this->pageSize,
            currentPage: $this->page,
            sortBy: $this->sortBy,
            sortDirection: $this->sortDirection
        );

        return view('users.index', [
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
        $roles = $this->role->GetInitialRole();

        // dd($rolesSelect);
        return view('users.manage' , [
            'roles' => $roles,
            'role' => [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request) : RedirectResponse
    {
        $this->user->CreateUser($request);

        return redirect()->route('users.index')->with('status', 'user-created');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user) : View
    {
        $user->loadMissing('role');
        return view('users.detail', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user) : View
    {
        $roles = $this->role->GetInitialRole();

        return view('users.manage', [
            'user'  => $user,
            'roles' => $roles,
            'role' => $this->role->GetRoleById($user->role_id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user) : RedirectResponse
    {
        $this->user->UpdateUser($user->id, $request);

        return redirect()->route('users.show', [$user->id])->with('status', 'user-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user) : RedirectResponse
    {
        $this->user->DeleteUser($user);

        return redirect()->route('users.index')->with('status', 'user-deleted');
    }
}
