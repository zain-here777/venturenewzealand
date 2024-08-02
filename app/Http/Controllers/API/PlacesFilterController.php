<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Services\PlacesFilterService;
use App\Services\PlacesService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PlacesFilterController extends Controller
{
    private PlacesFilterService $service;

    public function __construct(PlacesFilterService $placesFilterService )
    {
        $this->service  = $placesFilterService;
    }

    /**
     * @return array
     */
    public function fetchCategories(): array
    {
        return $this->service->fetchCategories();
    }

    /**
     * @return array
     */
    public function fetchPlaceTypes(): array
    {
        return $this->service->fetchPlaceTypes();
    }
}