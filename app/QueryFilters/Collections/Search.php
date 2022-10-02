<?php

namespace App\QueryFilters\Collections;

use App\QueryFilters\Filter;

class Search extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->where('name', 'LIKE', '%' . request($this->filterName()) . '%')
            ->orWhere('description', 'LIKE', '%' . request($this->filterName()) . '%');
    }
}
