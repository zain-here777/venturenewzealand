<?php

namespace App\Http\Controllers\Frontend;


use App\Models\City;
use App\Models\Post;
use App\Models\Place;
use App\Models\PlaceProduct;
use App\Models\Country;
use App\Models\Category;
use App\Commons\Response;
use App\Models\Amenities;
use App\Models\PlaceType;
use App\Models\Competition;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\NewsletterSubscribers;
use App\Models\RewardPointTransaction;
use Illuminate\Support\Facades\Session;
use App\Models\CompetitionParticipation;
use App\Models\HighlightedProduct;
use Illuminate\Support\Str;

class CountryController extends Controller
{
    public function detail($slug)
    {
        $country = Country:: query()
            ->where('slug', $slug)
            ->first();

        if (!$country) {
            abort(404);
        }

        $country_cities = City::query()
            ->with('country')
            ->withCount(['places' => function ($query) {
                $query->where('status', Place::STATUS_ACTIVE);
            }])
            ->where('status', Country::STATUS_ACTIVE)
            ->where('country_id', $country->id)
            ->limit(8)
            ->get();

        $highlightedProduct = new HighlightedProduct;
        $highlightedProducts = $highlightedProduct->getFullList(false);

        $categories = Category::query()
            ->where('categories.status', Category::STATUS_ACTIVE)
            ->where('categories.type', Category::TYPE_PLACE)
            ->where('places.status',Place::STATUS_ACTIVE)
            ->join('places', 'places.category', 'like', DB::raw("CONCAT('%', categories.id, '%')"))
            ->select('categories.id as id', 'categories.name as name','categories.description as description', 'categories.pricing_text as pricing_text', 'categories.priority as priority', 'categories.slug as slug', 'categories.color_code as color_code', 'categories.icon_map_marker as icon_map_marker', 'categories.small_icon', DB::raw("count(places.category) as place_count"))
            ->groupBy('categories.id')
            ->orderBy('categories.priority')
            ->limit(12)
            ->get();

        $country_trending_places = Place::query()
            ->with('categories')
            ->with('city')
            ->with('place_types')
            ->withCount('reviews')
            ->with('avgReview')
            ->withCount('wishList')
            ->where('status', Place::STATUS_ACTIVE)
            ->where('is_highlight', 1)
            ->where('country_id', $country->id)
            ->limit(10)
            ->get();

        $popular_places = Place::query()
            ->where('status', Place::STATUS_ACTIVE)
            ->where('is_popular', 1)
            ->limit(4)
            ->get();


        $destinations = City::query()
            ->where('status', City::STATUS_ACTIVE)
            ->orderBy('country_id', 'DESC')
            ->get();

        $regions = Country::query()
            ->where('status', Country::STATUS_ACTIVE)
            ->where('slug','!=', $slug)
            ->get();

        $title = $country->seo_title ? $country->seo_title : $country->name;
        $description = $country->seo_description ? $country->seo_description : Str::limit($country->description, 165);
        SEOMeta($title, $description, getImageUrl($country->banner));

        return view("frontend.country.country_01", [
            'country' => $country,
            'country_cities' => $country_cities,
            'categories' => $categories,
            'country_trending_places' => $country_trending_places,
            'highlightedProducts' => $highlightedProducts,
            'regions' => $regions
        ]);
    }
}
