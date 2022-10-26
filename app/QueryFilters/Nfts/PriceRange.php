<?php

namespace App\QueryFilters\Nfts;

use App\QueryFilters\Filter;

class PriceRange extends Filter
{
    protected function applyFilter($builder)
    {
        $arg = gettype(request($this->filterName())) == 'string' ? json_decode(request($this->filterName())) : request($this->filterName());
        return $builder->whereBetween('price', $arg);
    }
}
