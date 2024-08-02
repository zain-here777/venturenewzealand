<?php
namespace App\Services;

use App\Models\Interest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class InterestService
{
    /**
     * Get all interests, cached for 6 hours.
     *
     * @return Collection
     */
    public function getInterests(): Collection
    {
        return Cache::remember('interests', 6 * 60 * 60, function () {
            return Interest::all();
        });
    }

    /**
     * Get interests by category IDs.
     *
     * @param array $categoryIds
     * @return Collection|Interest[]
     */
    public function getInterestsByCategory(array $categoryIds): Collection|array
    {
        $interests = $this->getInterests();
        return $interests->whereIn('category_id', $categoryIds);
    }
}
