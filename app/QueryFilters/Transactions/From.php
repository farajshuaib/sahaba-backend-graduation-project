<?php

namespace App\QueryFilters\Transactions;

use App\QueryFilters\Filter;


class From extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->where('from', request($this->filterName()));
    }
}

