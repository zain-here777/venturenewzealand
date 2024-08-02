<?php

namespace App\Services;

use App\Helpers\Sanitizer;
use App\Models\Country;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class RegionService
{

    /**
     * @return Builder[]|Collection
     */
    public function fetchAllRegionsInNewZealand(): Collection|array
    {
        $regions = Country::query()
            ->select([
                'name',
                'slug',
                'description',
                'about',
            ])
            ->get();

        // Sanitize the description and about fields
        foreach ($regions as $region) {
            $region->description = Sanitizer::sanitizeText($region->description);
            $region->about = Sanitizer::sanitizeText($region->about);
        }

        return $regions;
    }
}