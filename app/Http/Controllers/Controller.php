<?php

namespace App\Http\Controllers;

use App\Http\Traits\HasPagination;
use App\Http\Traits\HasSearch;
use App\Http\Traits\HasSort;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller
{
    use AuthorizesRequests, ValidatesRequests, HasPagination, HasSearch, HasSort;
}
