<?php

namespace App\Interfaces\Iam;

use App\Http\Requests\Iam\UserRequest;
use App\Http\Resources\Iam\UserResource;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface UserInterface
{
    public function GetAllUser() : UserResource;
    public function GetPaginatedUser(string $search, int $perPage = 10, int $currentPage = 1, string $sortBy, string $sortDirection) : LengthAwarePaginator;
    public function GetOnlineUser() : Collection;
    public function CreateUser(UserRequest $request) : UserResource;
    public function UpdateUser(int $userId, UserRequest $request) : UserResource;
    public function DeleteUser(User $user) : void;
    public function GetUserBySearch(?User $user, string $search) : array;
    public function GetUserById(int $id) : array;
    public function GetUserByIds(array $ids) : array;
    public function GetInitialUser() : array;
}
