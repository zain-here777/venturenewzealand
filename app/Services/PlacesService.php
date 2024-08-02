<?php

namespace App\Services;

use App\Helpers\Sanitizer;
use App\Models\Place;
use Illuminate\Database\Eloquent\Builder;

class PlacesService
{
    use CustomPaginationOutputTrait;

    /**
     * @var InterestService
     */
    protected InterestService $interestService;

    /**
     * Constructor to initialize InterestService.
     *
     * @param InterestService $interestService
     */
    public function __construct(InterestService $interestService)
    {
        $this->interestService = $interestService;
    }

    /**
     * Fetch places in a specific city and their associated interests.
     *
     * @param string $citySlug
     * @param int $perPage
     * @return array
     */
    public function fetchPlacesInCity(string $citySlug, int $perPage = 10): array
    {
        $places = Place::query()
            ->where('status', Place::STATUS_ACTIVE)
            ->whereHas('city', function (Builder $query) use ($citySlug) {
                $query->where('slug', $citySlug);
            })
            ->with(['placeProducts' => function ($query) {
                $query->orderBy('id')->limit(1);
            }])
            ->paginate($perPage);

        // Transform the places data
        $places->getCollection()->transform(function (Place $place) {
            $firstPlaceProduct = $place->placeProducts->first();

            // Ensure the category field is converted to an array
            $categoryIds = is_array($place->category) ? $place->category : json_decode($place->category, true);
            $interests = $this->interestService->getInterestsByCategory($categoryIds);

            return [
                'name' => $place->name,
                'categories' => $place->category,
                'interests' => $interests->pluck('keyword')->toArray(),
                'place_types' => $place->place_type,
                'slug' => $place->slug,
                'address' => Sanitizer::sanitizeText($place->address),
                'description' => Sanitizer::sanitizeHtmlToPlainText($place->description),
                'price' => $firstPlaceProduct ? $firstPlaceProduct->price : null,
                'translations' => $place->translations->map(function ($translation) {
                    return [
                        'locale' => $translation->locale,
                        'name' => $translation->name ? Sanitizer::sanitizeText($translation->name) : null,
                        'description' => $translation->description ? Sanitizer::sanitizeHtmlToPlainText($translation->description) : null,
                    ];
                })->toArray()
            ];
        });

        // Customize the response
        return $this->fromAbstractPaginator($places);
    }
}
