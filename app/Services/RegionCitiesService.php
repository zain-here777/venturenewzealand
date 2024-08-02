<?php

namespace App\Services;

use App\Helpers\Sanitizer;
use App\Models\City;
use App\Models\Place;
use Illuminate\Database\Eloquent\Builder;

class RegionCitiesService
{
    use CustomPaginationOutputTrait;

    /**
     * @param string $regionSlug
     * @param int $perPage
     * @return array
     */
    public function fetchCitiesInRegion(string $regionSlug, int $perPage = 10): array
    {
        $cities = City::query()
            ->whereHas('country', function (Builder $query) use ($regionSlug) {
                $query->where('slug', $regionSlug);
            })
            ->withCount(['places' => function ($query) {
                $query->where('status', Place::STATUS_ACTIVE);
            }])
            ->paginate($perPage);

        // Transform the cities data
        $cities->getCollection()->transform(function ($city) {
            return [
                'name' => $city->name,
                'slug' => $city->slug,
                'intro' => Sanitizer::sanitizeText($city->intro),
                'description' => Sanitizer::sanitizeText($city->description),
                'link' => url("/city/{$city->slug}"),
                'best_time_to_visit' => $city->best_time_to_visit,
                'lat' => $city->lat,
                'lng' => $city->lng,
                'places_count' => $city->places_count,
                'translations' => $city->translations->map(function ($translation) {
                    return [
                        'locale' => $translation->locale,
                        'name' => $translation->name,
                        'intro' => Sanitizer::sanitizeText($translation->intro),
                        'description' => Sanitizer::sanitizeText($translation->description),
                    ];
                })->toArray()
            ];
        });

        return $this->fromAbstractPaginator($cities);
    }
}
