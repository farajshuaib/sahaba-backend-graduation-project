<?php

namespace App\QueryFilters\Notifications;

use App\QueryFilters\Filter;

class Read extends Filter
{
    protected function applyFilter($builder)
    {
        if (request($this->filterName())) {
            return $builder->whereNotNull('read_at');
        }

        return $builder->whereNull('read_at');
    }
}