<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use App\Models\Amenities;
use App\Models\Category;
use App\Models\City;
use App\Models\Place;
use App\Models\PlaceType;
use App\Models\UserInterest;
use App\Models\PlaceInterest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CityController extends Controller
{
    private $city;

    public function __construct(City $city)
    {
        $this->city = $city;
    }

    public function list()
    {

    }

    public function detail(Request $request, $slug)
    {
        /**
         * Get info city
         */
        $city = $this->city->getBySlug($slug);
        if (!$city) abort(404);
        if(auth()->user()){
            $user_id = auth()->user()->id;
            $user_interest = UserInterest::where('user_id', $user_id)
                        ->select('interest_id')
                        ->get();
            $user_interestArr = [];
            foreach($user_interest as $key){
                $user_interestArr[] = $key->interest_id;
            }
        }

        /**
         * Menu category
         */
        $categories = Category::query()
//            ->with('places')
            ->where('categories.status', Category::STATUS_ACTIVE)
            ->join('places', 'places.category', 'like', DB::raw("CONCAT('%', categories.id, '%')"))
            ->select('categories.id as id', 'categories.name as name', 'categories.priority as priority', 'categories.slug as slug','categories.color_code as color_code', DB::raw("count(places.category) as place_count"))
            ->groupBy('categories.id')
            ->orderBy('categories.priority')
            ->get();

        /**
         * Loop categories feature and its places
         */
        // $category_features = Category::query()
        //     ->where('is_feature', Category::IS_FEATURE)
        //     ->where('status', Category::STATUS_ACTIVE)
        //     ->orderBy('categories.priority')
        //     ->get(['id', 'name', 'slug', 'feature_title', 'color_code']);
        // $features = [];
        // foreach ($category_features as $cat) {
            $places = Place::query()
                ->with('place_types')
                ->withCount('reviews')
                ->with('avgReview')
                ->with('place_interests')
                ->withCount('wishList')
                ->where('city_id', $city->id)
                // ->where('category', 'like', '%' . $cat->id . '%')
                ->where('status', Place::STATUS_ACTIVE)
                ->get();
        //     $features[] = [
        //         'category_id' => $cat->id,
        //         'category_name' => $cat->name,
        //         'category_slug' => $cat->slug,
        //         'feature_title' => $cat->feature_title,
        //         'category_color' => $cat->color_code,
        //         'places' => $places,
        //     ];
        // }

        if(auth()->user()){
            foreach($places as $place){
                $i = 0;
                foreach($place->place_interests as $keyword){
                    if(in_array($keyword->interest_id, $user_interestArr)){
                        $i++;
                    }
                }
                $place->user_interest_count = $i;

            }
            $places = $places->sortByDesc('user_interest_count');
        }
        /**
         * Get places of category when user click to menu category
         */
        $places_by_category = [];
        $place_types = null;
        $amenities = null;

        // $cat = Category::query()
        //     ->where('slug', $cat_slug)
        //     ->where('status', Category::STATUS_ACTIVE)
        //     ->first(['id', 'name', 'slug']);

        // $places_by_category['category'] = $cat;
        // $places_by_category['places'] = Place::query()
        //     ->with('place_types')
        //     ->withCount('reviews')
        //     ->with('avgReview')
        //     ->withCount('wishList')
        //     ->where('city_id', $city->id)
        //     ->where('category', 'like', '%' . $cat->id . '%')
        //     ->where('status', Place::STATUS_ACTIVE)
        //     ->paginate();

        $place_types = PlaceType::query()
        ->select('place_types.*')
        ->join('categories', 'place_types.category_id', '=', 'categories.id')
        ->groupBy('place_types.id')
        ->get();

        $amenities = Amenities::query()->get();


        /**
         * Block: Explorer Other Cities
         */
        $other_cities = Cache::remember('other_cities', 60 * 60, function () use ($city) {
            return City::query()
                ->withCount('places')
                ->with('country')
                ->where('status', City::STATUS_ACTIVE)
                ->where('id', '<>', $city->id)
                ->inRandomOrder()
                ->limit(4)
                ->get();
        });

//        return $places_by_category;

        /**
         * SEO Meta
         */
        $title = $city->seo_title ? $city->seo_title : $city->name;
        $description = $city->seo_description ? $city->seo_description : Str::limit($city->description, 165);
        SEOMeta($title, $description, getImageUrl($city->banner));

        return view('frontend.city.city_detail', [
            'city' => $city,
            'categories' => $categories,
            'places' => $places,
            'other_cities' => $other_cities,
            'place_types' => $place_types,
            'amenities' => $amenities,
        ]);
    }

    public function getListByCountry($country_id)
    {
        $cities = City::query();
        if ($country_id) {
            $cities->where('country_id', $country_id);
        }
        $cities = $cities->orderBy('created_at', 'desc')->get();
        return $cities;
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;

        $cities = City::query();

        if (isset($keyword)) {
            $cities->whereTranslationLike('name', "%{$keyword}%");
        }

        $cities = $cities->limit(20)->get();

        return $cities;
    }
}
