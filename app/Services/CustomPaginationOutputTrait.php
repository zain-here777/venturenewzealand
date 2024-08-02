<?php

namespace App\Services;

use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Pagination\LengthAwarePaginator;

trait CustomPaginationOutputTrait
{
    /**
     * @param AbstractPaginator|LengthAwarePaginator $data
     * @return array
     */
    public function fromAbstractPaginator(LengthAwarePaginator|AbstractPaginator $data): array
    {
        return [
            'data' => $data->items(),
            'current_page' => $data->currentPage(),
            'per_page' => $data->perPage(),
            'first_page' => $data->firstItem(),
            'last_page' => $data->lastPage(),
            'total_items' => $data->total(),
        ];
    }
}