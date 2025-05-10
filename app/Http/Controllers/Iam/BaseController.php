<?php

namespace App\Http\Controllers\Iam;

use App\Http\Controllers\Controller;
use App\Interfaces\Iam\PermissionInterface;
use App\Interfaces\Iam\RoleInterface;
use App\Interfaces\Iam\UserInterface;

class BaseController extends Controller
{
    public function __construct(protected UserInterface $user, protected RoleInterface $role, protected PermissionInterface $permission) {
    }
}
