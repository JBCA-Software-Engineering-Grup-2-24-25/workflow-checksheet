<?php

namespace App\Providers;

use App\Interfaces\Permission\PermissionInterface;
use App\Interfaces\Role\RoleInterface;
use App\Repositories\PermissionRepository;
use App\Repositories\Role\RoleRepository;
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
        //
    }
}
