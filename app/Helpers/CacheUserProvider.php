<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Support\Facades\Cache;

/**
 * Class CacheUserProvider
 * @package App\Auth
 */
class CacheUserProvider extends EloquentUserProvider
{
    /**
     * CacheUserProvider constructor.
     * @param HasherContract $hasher
     */
    public function __construct(HasherContract $hasher)
    {
        parent::__construct($hasher, User::class);
    }

    /**
     * @param mixed $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        if (! Cache::has('user.' . $identifier)) {
            /** @var User $user */
            $user = parent::retrieveById($identifier);
            $user->loadMissing(['media', 'role.permissions']);
            Cache::add('user.' . $identifier, $user, 3600);
        }

        return Cache::get('user.' . $identifier);
    }
}
