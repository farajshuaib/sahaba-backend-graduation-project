<?php

namespace App\QueryFilters\Users;

use App\QueryFilters\Filter;

class SortBy extends Filter
{
    // Popular, Following, New
    protected function applyFilter($builder)
    {
        return match (request($this->filterName())) {
            'Popular-creator' => $builder->orderBy('created_nfts_count', 'desc'),
            'Popular-collector' => $builder->orderBy('owned_nfts_count', 'desc'),
            'New' => $builder->orderBy('created_at', 'desc'),
            default => $builder->orderBy('id', 'desc'),
        };
    }
}

