<?php

namespace App\QueryFilters\Transactions;

use App\QueryFilters\Filter;

class Nft extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->where('nft_id', request($this->filterName()));
    }
}
