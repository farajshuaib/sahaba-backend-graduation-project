<?php
namespace App\Helpers;

class PaginationMeta
{
    public static function getPaginationMeta($collection)
    {
        if (!$collection)
            return [];

        $from = (($collection->currentPage() - 1) * $collection->perPage()) + 1;
        $to = $from + $collection->count() - 1;

        return [
            'total' => $collection->total(),
            'from' => $from,
            'to' => $to,
            'count' => $collection->count(),
            'per_page' => $collection->perPage(),
            'current' => $collection->currentPage(),
            'last_page' => $collection->lastPage(),
        ];
    }
}

?>
