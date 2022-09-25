<?php

namespace App\QueryFilters\Collections;

use App\QueryFilters\Filter;

class Category extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->whereHas('category', function ($query) {
            $query->where('id', request($this->filterName()));
        });
    }

}
