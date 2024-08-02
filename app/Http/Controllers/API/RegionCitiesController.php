<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Services\RegionCitiesService;

class RegionCitiesController extends Controller
{
    /**
     * @param RegionCitiesService $service
     * @param string $regionSlug
     * @return array
     */
    public function index(RegionCitiesService $service, string $regionSlug ): array
    {
        $perPage = request()->query('per_page', 10); // Default to 10 per page if not provided
        return $service->fetchCitiesInRegion($regionSlug, $perPage);
    }
}