<?php

namespace App\QueryFilters\Nfts;

use App\QueryFilters\Filter;

class Owner extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->where('owner_id', request($this->filterName()));
    }
}

