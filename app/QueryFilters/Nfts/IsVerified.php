<?php

namespace App\QueryFilters\Nfts;

use App\QueryFilters\Filter;

class IsVerified extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->whereHas('owner', function ($query) {
            $query->whereHas('kyc', function ($query) {
                $query->where('status', '=', 'verified');
            });
        });

    }

}
