<?php

namespace App\QueryFilters\Reports;

use App\QueryFilters\Filter;

class ReportableId extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->where('reportable_id', request($this->filterName()));
    }
}

