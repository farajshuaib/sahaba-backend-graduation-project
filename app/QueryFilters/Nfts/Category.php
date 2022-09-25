<?php


namespace App\QueryFilters\Nfts;

use App\QueryFilters\Filter;

class Category extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->whereHas('collection.category', function ($query) {
            $query->when(request()->filled($this->filterName()), function ($query) {
                $query->where('id', request($this->filterName()));
            });
        });
    }
}
