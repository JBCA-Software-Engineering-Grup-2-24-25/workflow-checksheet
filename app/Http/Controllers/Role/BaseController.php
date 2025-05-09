<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Interfaces\Permission\PermissionInterface;
use App\Interfaces\Role\RoleInterface;

class BaseController extends Controller
{
    public function __construct(protected RoleInterface $role, protected PermissionInterface $permission) {
    }
}
