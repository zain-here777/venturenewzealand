<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Services\RegionService;
use Illuminate\Database\Eloquent\Collection;

class RegionsController extends Controller
{
    /**
     * @param RegionService $service
     * @return Collection|array
     */
    public function index(RegionService $service): Collection|array
    {
        return $service->fetchAllRegionsInNewZealand();
    }
}