<?php

namespace App\QueryFilters\Nfts;

use App\QueryFilters\Filter;

class Creator extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->where('creator_id', request($this->filterName()));
    }
}

