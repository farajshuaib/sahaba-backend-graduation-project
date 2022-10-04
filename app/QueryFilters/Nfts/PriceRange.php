<?php

namespace App\QueryFilters\Nfts;

use App\QueryFilters\Filter;

class PriceRange extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->whereBetween('price', [request($this->filterName())[0], request($this->filterName())[1]]);
    }
}
