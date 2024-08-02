<?php

namespace App\Services;

use App\Models\Category;
use App\Models\PlaceType;

class PlacesFilterService
{
    /**
     * @return array
     */
    public function fetchCategories(): array
    {
        $categories = Category::query()
            ->with('interest' )
            ->where('status', Category::STATUS_ACTIVE)
            ->where('type', Category::TYPE_PLACE )
            ->with('translations') // Eager load translations
            ->get();

        // Transform the categories data
        $transformedCategories = $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
                'slug' => $category->slug,
                'interest' => $category->interest->pluck('keyword'),
                'translations' => $category->translations->map(function ($translation) {
                    return [
                        'locale' => $translation->locale,
                        'name' => $translation->name,
                    ];
                })->toArray(),
            ];
        });

        return $transformedCategories->toArray();
    }

    /**
     * @return array
     */
    public function fetchPlaceTypes(): array
    {
        $placeTypes = PlaceType::query()
            ->with('translations') // Eager load translations
            ->get();

        // Transform the data
        $transformedData = $placeTypes->map(function ($placeType) {
            return [
                'id' => $placeType->id,
                'translations' => $placeType->translations->map(function ($translation) {
                    return [
                        'locale' => $translation->locale,
                        'name' => $translation->name,
                    ];
                })->toArray(),
            ];
        });

        return $transformedData->toArray();
    }
}
