<?php


namespace App\QueryFilters\Nfts;

use App\QueryFilters\Filter;

class Collection extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->where('collection_id', request($this->filterName()));
    }
}
