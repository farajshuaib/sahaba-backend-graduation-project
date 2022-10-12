<?php

namespace App\QueryFilters\Users;

use App\QueryFilters\Filter;

class Search extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->where('first_name', 'like', '%' . request($this->filterName()) . '%')
            ->orWhere('last_name', 'like', '%' . request($this->filterName()) . '%')
            ->orWhere('email', 'like', '%' . request($this->filterName()) . '%')
            ->orWhere('wallet_address', 'like', '%' . request($this->filterName()) . '%')
            ->orWhere('username', 'like', '%' . request($this->filterName()) . '%');
    }
}
