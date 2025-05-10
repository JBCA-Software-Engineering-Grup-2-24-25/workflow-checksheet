<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

trait HasSort
{
    protected array $sortChoices = [];
    protected string $sortBy = '';
    protected string $sortDirection = '';

    protected function setSortChoices(array $sortChoices) : void
    {
        $this->sortChoices = $sortChoices;
    }

    protected function setSort(Request $request)
    {
        $sort = $request->query('sortBy') ?? '';
        // dd($sort);

        if (! empty($sort) && array_key_exists($sort, $this->sortChoices)) {
            $sortArray = explode('-', $sort);
            $this->sortBy = $sortArray[0];
            $this->sortDirection = $sortArray[1];
        }
    }
}
