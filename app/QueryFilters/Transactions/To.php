<?php

namespace App\QueryFilters\Transactions;

use App\QueryFilters\Filter;

class To extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->where('to', request($this->filterName()));
    }
}
