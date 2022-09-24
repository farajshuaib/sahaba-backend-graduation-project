<?php

namespace App\QueryFilters;

use Closure;
use Illuminate\Support\Str;

abstract class Filter
{
    public function handle($request, Closure $next): mixed
    {
        if (!request()->has($this->filterName())) {
            return $next($request);
        }
        $builder = $next($request);
        return $this->applyFilter($builder);
    }

    protected function filterName(): string
    {
        return Str::snake(class_basename($this));
    }

    protected abstract function applyFilter($builder);
}
