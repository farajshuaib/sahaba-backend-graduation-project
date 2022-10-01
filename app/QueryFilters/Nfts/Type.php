<?php

namespace App\QueryFilters\Nfts;

use App\QueryFilters\Filter;

class Type extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->where('file_type', '=', request($this->filterName()));


    }
}
