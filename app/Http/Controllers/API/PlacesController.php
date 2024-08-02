<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Services\PlacesService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PlacesController extends Controller
{
    /**
     * @param PlacesService $service
     * @param string $citySlug
     * @return array
     */
    public function index(PlacesService $service, string $citySlug ): array
    {
        $perPage = request()->query('per_page', 10); // Default to 10 per page if not provided
        return $service->fetchPlacesInCity($citySlug, $perPage);
    }
}