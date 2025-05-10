<?php

namespace App\Repositories\Iam;

use App\Http\Requests\Iam\UserRequest;
use App\Http\Resources\Iam\UserResource;
use App\Interfaces\Iam\RoleInterface;
use App\Interfaces\Iam\UserInterface;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserInterface
{
    public function __construct(private User $model, private RoleInterface $role)
    {
    }

    public function GetAllUser() : UserResource
    {
        $users = $this->model->get();

        return new UserResource($users);
    }

    public function GetPaginatedUser(string $search, int $perPage = 10, int $currentPage = 1, string $sortBy, string $sortDirection) : LengthAwarePaginator
    {
        return $this->model::query()
            ->when(!empty($search), fn(Builder $query, $search) => $query->where('name', 'like', '%' . strtolower($search) . '%'))
            ->when(! empty($sortBy) && ! empty($sortDirection), fn (Builder $query) => $query->orderBy($sortBy, $sortDirection))
            ->when(empty($sortBy) && empty($sortDirection), fn (Builder $query) => $query->latest())
            ->with('role')
            ->paginate(perPage: $perPage, page: $currentPage);
    }

    public function GetOnlineUser() : Collection
    {
        $timeExp = Carbon::now()->subMinutes(config('auth.user_online_expired'));

        return $this->model::query()
            ->where('last_seen', '>=', $timeExp)
            ->with('media')
            ->get();
    }

    public function CreateUser(UserRequest $request) : UserResource
    {
        $data = $request->validated();
        $data['author_id'] = Auth::user()->id;

        $user = $this->model->query()->create($data);

        return new UserResource($user);
    }

    public function UpdateUser(int $userId, UserRequest $request) : UserResource
    {
        $user = $this->model->query()
            ->where('id', '=', $userId)
            ->first();

        $data = $request->validated();
        $user = $user->update($data);

        return new UserResource($user);
    }

    public function DeleteUser(User $user) : void
    {
        // TODO: Add checking if user has workflow. if true then its not possible to delete user

        $user->delete();
    }

    public function GetUserBySearch(?User $user, string $search) : array
    {
        return $this->model->query()
            ->where(DB::raw('lower(name)'), 'like', '%' . strtolower($search) . '%')
            ->when($user !== null, fn ($query) => $query->where('id', '!=', $user->id))
            ->where('deactivated_at', '=', null)
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

    public function GetUserById(int $id) : array
    {
        /** @var User $user */
        $user = $this->model->query()
            ->where('id', '=', $id)
            ->where('deactivated_at', '=', null)
            ->first();

        if ($user === null) {
            return [];
        }

        return [
            'label' => $user->name,
            'value' => $user->id,
            'selected' => true,
        ];
    }

    public function GetUserByIds(array $ids) : array
    {
        return $this->model->query()
            ->when(! empty($ids), fn ($query) => $query->whereIn('id', $ids))
            ->where('deactivated_at', '=', null)
            ->get()
            ->map(function ($model) {
                return [
                    'label' => $model->name,
                    'value' => $model->id,
                    'selected' => true,
                ];
            })
            ->toArray();
    }

    public function GetInitialUser() : array
    {
        return $this->model->query()
            ->where('deactivated_at', '=', null)
            ->latest()
            ->take(3)
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
