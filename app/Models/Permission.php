<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

/**
 * @property string $name
 * @property ?string $description
 * @property string $route
 * @property Collection $roles
 * @property-read int $id
 * @property-read bool $is_default
 * @property-read string $route_prefix
 * @property-read ?\Illuminate\Support\Carbon $created_at
 * @property-read ?\Illuminate\Support\Carbon $updated_at
 * @property-read ?\Illuminate\Support\Carbon $deleted_at
 */
class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'route'
    ];

    /**
     * The roles that belong to the Permission
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }

    public function IsDefault() : Attribute
    {
        return Attribute::make(
            get: fn() => in_array($this->route, config('permission.default'))
        );
    }

    public function RoutePrefix() : Attribute
    {
        return Attribute::make(
            get: function () : string {
                $exceptSearch = ['media.'];
                $exceptReplace = [''];
                $route = str_replace($exceptSearch, $exceptReplace, $this->route);
                $routes = collect(explode('.', $route));
                $routes->pop();
                return $routes->join('-');
            }
        );
    }

    public function NamePrefix() : Attribute
    {
        return Attribute::make(
            get: function () : string {
                $routes = collect(explode('.', $this->route));
                $routes->pop();
                return 'Manage ' . Str::apa(str_replace('-', ' ', $routes->join(' ')));
            }
        );
    }
}
