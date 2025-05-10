<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

trait HasPagination
{
    protected int $page = 0;
    protected int $pageSize = 0;

    protected function setPagination(Request $request)
    {
        $this->page = $request->query('page') ?? 1;
        $this->pageSize = $request->query('pageSize') ?? 10;
    }
}
