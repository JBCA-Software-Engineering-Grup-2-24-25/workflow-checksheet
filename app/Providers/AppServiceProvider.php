<?php

namespace App\Providers;

use App\Helpers\CacheUserProvider;
use App\Interfaces\Iam\PermissionInterface;
use App\Interfaces\Iam\RoleInterface;
use App\Interfaces\Iam\UserInterface;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use App\Repositories\Iam\PermissionRepository;
use App\Repositories\Iam\RoleRepository;
use App\Repositories\Iam\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';


    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        RoleInterface::class => RoleRepository::class,
        PermissionInterface::class => PermissionRepository::class,
        UserInterface::class => UserRepository::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Auth::provider('cache-user', function() {
            return resolve(CacheUserProvider::class);
        });

        Gate::before(function ($user, $ability) {
            if ($user->role->permissions->where('route', 'superadmin')->count() > 0 && ! in_array($ability, config('permission.skips'))) {
                return true;
            }
        });

        $this->GateRole();
        $this->GatePermission();
        $this->GateUser();
    }

    private function GateRole() : void
    {
        Gate::define('roles.index', [RolePolicy::class, 'viewAny']);
        Gate::define('roles.show', [RolePolicy::class, 'view']);
        Gate::define('roles.store', [RolePolicy::class, 'create']);
        Gate::define('roles.update', [RolePolicy::class, 'update']);
        Gate::define('roles.destroy', [RolePolicy::class, 'delete']);
    }

    private function GatePermission() : void
    {
        Gate::define('permission.index', [PermissionPolicy::class, 'viewAny']);
        Gate::define('permission.update', [PermissionPolicy::class, 'update']);
    }

    private function GateUser() : void
    {
        Gate::define('users.index', [UserPolicy::class, 'viewAny']);
        Gate::define('users.show', [UserPolicy::class, 'view']);
        Gate::define('users.store', [UserPolicy::class, 'create']);
        Gate::define('users.update', [UserPolicy::class, 'update']);
        Gate::define('users.destroy', [UserPolicy::class, 'delete']);
    }
}
