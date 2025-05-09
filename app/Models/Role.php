<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $name
 * @property int $author_id
 * @property \Illuminate\Database\Eloquent\Collection $permissions
 * @property-read bool $deleteable
 * @property-read ?\Illuminate\Support\Carbon $created_at
 * @property-read ?\Illuminate\Support\Carbon $updated_at
 * @property-read ?\Illuminate\Support\Carbon $deleted_at
 */
class Role extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'author_id'
    ];

    protected $appends = [
        'deleteable'
    ];

    /**
     * RoleUser
     *
     * @return void
     */
    public function users() : HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * The permissions that belong to the RoleUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id');
    }

    public function Deleteable() : Attribute
    {
        return Attribute::make(
            get: fn() => isset($this->users_count) && $this->users_count > 0 ? false : true
        );
    }
}
