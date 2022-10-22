<?php

namespace App\QueryFilters\Reports;

use App\QueryFilters\Filter;

class Reportable extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->where('reportable_type', request($this->filterName()));
    }
}

