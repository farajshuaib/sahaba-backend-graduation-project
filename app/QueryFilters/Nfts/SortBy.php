<?php

namespace App\QueryFilters\Nfts;

use App\QueryFilters\Filter;

class SortBy extends Filter
{
    protected function applyFilter($builder)
    {
        return match (request($this->filterName())) {
            'Recently-listed' => $builder->orderBy('created_at', 'desc'),
            'Ending-soon' => $builder->orderBy('sale_end_at', 'desc'),
            'Price-low-high' => $builder->orderBy('price', 'asc'),
            'Price-high-low' => $builder->orderBy('price', 'desc'),
            'Most-favorite' => $builder->orderBy('likers_count', 'desc'),
            default => $builder->orderBy('id', 'desc'),
        };
    }
}
