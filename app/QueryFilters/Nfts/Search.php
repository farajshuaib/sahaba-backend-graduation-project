<?php


namespace App\QueryFilters\Nfts;

use App\QueryFilters\Filter;

class Search extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->where('title', 'LIKE', '%' . request($this->filterName()) . '%')
            ->orWhere('description', 'LIKE', '%' . request($this->filterName()) . '%')
            ->orWhere('file_path', 'LIKE', '%' . request($this->filterName()) . '%');
    }
}
