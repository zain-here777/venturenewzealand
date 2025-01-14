<?php


namespace App\Http\Controllers\Frontend;


use App\Commons\Response;
use App\Http\Controllers\Controller;
use App\Models\Amenities;
use App\Models\Category;
use App\Models\City;
use App\Models\Place;
use App\Models\PlaceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class CategoryController extends Controller
{
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function listPlace(Request $request, $slug)
    {
        $keyword = $request->keyword;
        $filter_category = $request->category;
        $filter_amenities = $request->amenities;
        $filter_place_type = $request->place_type;
        $filter_city = $request->city;


        $categories = Category::query()
            ->where('type', Category::TYPE_PLACE)
            ->get();

        $place_types = PlaceType::query()
            ->get();

        $amenities = Amenities::query()
            ->get();

        $cities = City::query()
            ->get();


        $category = Category::query()
            ->where('slug', $slug)
            ->first();

        $places = Place::query()
            ->with(['city' => function ($query) {
                return $query->select('id', 'name', 'slug');
            }])
            ->with('categories')
            ->with('place_types')
            ->withCount('reviews')
            ->with('avgReview')
            ->withCount('wishList')
            ->orWhere('address', 'like', "%{$keyword}%")
            ->whereTranslationLike('name', "%{$keyword}%")
            ->when(isset($category->id), function ($q) use ($category) {
                $q->where('category', 'like', "%$category->id%");
            })
            ->where('status', Place::STATUS_ACTIVE);


        if (isset($filter_category)) {
            foreach ($filter_category as $item) {
                $places->where('category', 'like', "%$item%");
            }
        }

        if (isset($filter_amenities)) {
            foreach ($filter_amenities as $item) {
                $places->where('amenities', 'like', "%$item%");
            }
        }

        if (isset($filter_place_type)) {
            foreach ($filter_place_type as $item) {
                $places->where('place_type', 'like', "%$item%");
            }
        }

        if (isset($filter_city)) {
            $places->whereIn('city_id', $filter_city);
        }

        if ($request->ajax()) {
            $places = $places->get();

            $city = [];
            if (isset($filter_city)) {
                $city = City::query()
                    ->whereIn('id', $filter_city)
                    ->first();
            }

            $data = [
                'city' => $city,
                'places' => $places
            ];

            return $this->response->formatResponse(200, $data, 'success');
        }

        $places = $places->paginate();

        return view('frontend.category.category_list', [
            'places' => $places,
            'category' => $category,
            'categories' => $categories,
            'place_types' => $place_types,
            'amenities' => $amenities,
            'cities' => $cities,
            'filter_category' => $filter_category,
            'filter_amenities' => $filter_amenities,
            'filter_place_type' => $filter_place_type,
            'filter_city' => $request->city,
        ]);
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;

        $categories = Category::query()
            ->whereTranslationLike('name', "%{$keyword}%")
            ->where('type', Category::TYPE_PLACE)
            ->limit(20)
            ->get();

        return $categories;
    }

    public function subCategory(Request $request)
    {

        $locale=Lang::getLocale();
        if (isset($request->category_ids)) {
            $sub_categories = DB::table('place_types')
                ->join('place_type_translations', 'place_type_translations.place_type_id', '=', 'place_types.id')
                ->select('place_types.id', 'place_type_translations.name')
                ->where('place_type_translations.locale',$locale)
                ->when(is_array($request->category_ids), function ($q) use ($request) {
                    $q->whereIn('category_id', $request->category_ids);
                })->when(!is_array($request->category_ids), function ($q) use ($request) {
                    $q->where('category_id', $request->category_ids);
                })->get();
            if ($sub_categories) {
                return response()->json(['status' => true, 'data' => $sub_categories]);
            } else {
                return response()->json(['status' => false, 'data' => 'Place Type not found!']);
            }
        } else {
            return response()->json(['status' => false, 'data' => 'Select category first!']);
        }
    }

    public function Keyword(Request $request)
    {
        if (isset($request->category_ids)) {
            $keywords = DB::table('interests')
                ->select('id', 'keyword')
                ->when(is_array($request->category_ids), function ($q) use ($request) {
                    $q->whereIn('category_id', $request->category_ids);
                })
                ->when(!is_array($request->category_ids), function ($q) use ($request) {
                    $q->where('category_id', $request->category_ids);
                })
                ->get();
            if ($keywords) {
                return response()->json(['status' => true, 'data' => $keywords]);
            } else {
                return response()->json(['status' => false, 'data' => 'Keyword not found!']);
            }
        } else {
            return response()->json(['status' => false, 'data' => 'Select category first!']);
        }
    }

    public function placeTypesForCategory(Request $request)
    {
        if (isset($request->category_ids)) {
            $sub_categories = Category::query()->with('place_type')->whereIn('id', $request->category_ids)->get();

            if ($sub_categories) {
                return response()->json(['status' => true, 'data' => $sub_categories]);
            } else {
                return response()->json(['status' => false, 'data' => 'Sub categories not found!']);
            }
        } else {
            return response()->json(['status' => false, 'data' => 'Select category first!']);
        }
    } //placeTypesForCategory()

}
