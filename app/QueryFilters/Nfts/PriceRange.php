<?php

namespace App\QueryFilters\Nfts;

use App\QueryFilters\Filter;

class PriceRange extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->where('price', 'between', request($this->filterName())[0] . 'and' . request($this->filterName())[1]);
    }
}
