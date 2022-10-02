<?php

namespace App\QueryFilters\Nfts;

use App\QueryFilters\Filter;

class IsVerified extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->whereHas('owner', function ($query) {
            $query->where('is_verified', '=', request($this->filterName()));
        });
    }

}
