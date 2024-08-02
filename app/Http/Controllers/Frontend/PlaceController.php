<?php

namespace App\Http\Controllers\Frontend;


use Exception;
use Carbon\Carbon;
use Stripe\Product;
use App\Models\City;
use App\Models\Place;
use App\Models\Review;
use GuzzleHttp\Client;
use App\Models\Country;
use Logic\PinGenerator;
use App\Models\Category;
use App\Models\Interest;
use App\Models\PlaceInterest;
use App\Models\Wishlist;
use App\Commons\Response;
use App\Models\Amenities;
use App\Models\PlaceType;
use App\Models\CityWeather;
use Illuminate\Support\Str;
use App\Models\PlaceProduct;
use App\Models\PlaceProductWishlist;
use Illuminate\Http\Request;
use App\Models\WebNotification;
use App\Http\Controllers\Controller;
use App\Models\BookingAvailibility;
use App\Models\User;
use App\Models\UserInterest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Models\WebNotificationAction;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Support\Facades\DB;

class PlaceController extends Controller
{
    private $place;
    private $country;
    private $city;
    private $category;
    private $amenities;
    private $response;

    public function __construct(Place $place, Country $country, City $city, Category $category, Amenities $amenities, Response $response)
    {
        $this->place = $place;
        $this->country = $country;
        $this->city = $city;
        $this->category = $category;
        $this->amenities = $amenities;
        $this->response = $response;
    }

    public function detail($slug)
    {
        $place = $this->place->getBySlug($slug);

        if (!$place) abort(404);

        $city = City::query()
            ->with('country')
            ->where('id', $place->city_id)
            ->first();

        $amenities = Amenities::query()
            ->whereIn('id', $place->amenities ? $place->amenities : [])
            ->get(['id', 'name', 'icon']);

        $categories = Category::query()
            ->whereIn('id', $place->category ? $place->category : [])
            ->get(['id', 'name', 'slug', 'icon_map_marker']);

        $place_types = PlaceType::query()
            ->whereIn('id', $place->place_type ? $place->place_type : [])
            ->get(['id', 'name']);

        $reviews = Review::query()
            ->with('user')
            ->where('place_id', $place->id)
            ->where('status', Review::STATUS_ACTIVE)
            ->get();
        $review_score_avg = Review::query()
            ->where('place_id', $place->id)
            ->where('status', Review::STATUS_ACTIVE)
            ->avg('score');

        $similar_places = Place::query()
            ->with('place_types')
            ->with('avgReview')
            ->withCount('reviews')
            ->withCount('wishList')
            ->where('city_id', $city->id)
            ->where('id', '<>', $place->id)
            ->whereHas('categories');
        if (isset($place->category)) {
            foreach ($place->category as $cat_id) :
                $similar_places->where('category', 'like', "%{$cat_id}%");
            endforeach;
        }

        $similar_places = $similar_places->limit(4)->get();

        //        return $categories;


        //        date_default_timezone_set('Asia/Ho_Chi_Minh');
        //        $date = getdate();
        //
        //        print_r(strtotime('05 PM'));
        //
        //
        //        $time_open = "12:00:00";
        //        $time_close = "17:00:00";
        //
        //
        //        if ((time() > strtotime($time_open)) && (time() < strtotime($time_close))) {
        //            echo "Open";
        //        } else {
        //            echo "Close";
        //        }


        // SEO Meta
        $title = $place->seo_title ? $place->seo_title : $place->name;
        $description = $place->seo_description ? $place->seo_description : Str::limit($place->description, 165);
        SEOMeta($title, $description, getImageUrl($place->thumb));

        $template = setting('template', '01');
        User::addUserViewPlaceRecently($place->id);
        $logo = $place->logo != null ? getImageUrl($place->logo) : null;

        return view("frontend.place.place_detail_{$template}", [
            'logo' => $logo,
            'place' => $place,
            'city' => $city,
            'amenities' => $amenities,
            'categories' => $categories,
            'place_types' => $place_types,
            'reviews' => $reviews,
            'review_score_avg' => $review_score_avg,
            'similar_places' => $similar_places,
            'category_slug' => $categories[0]->slug
        ]);
    }

    public function pageAddNew(Request $request, $slug = null)
    {
        // dd($request->all());
        // $place = Place::find($id)->with('products')->first();
        $user_id = auth()->user()->id;
        $user_info = User::where('id', $user_id)
                    ->select('name', 'avatar', 'phone_number', 'email', 'phone_number')
                    ->first();
        if(isOperatorUser() && !isUserAdmin()){
            $operator_place = Place::query()
            ->where('user_id', $user_id)
            ->first();
        }
        if(isOperatorUser() && isUserAdmin()){
            $operator_place = Place::query()
            ->where('user_id', $user_id)
            ->get();
        }
        $place = [];
        if (!empty($slug)) {
            $place = Place::where('slug', $slug)->with('products')->first();
            abort_if(collect($place)->isEmpty(), 500, 'Product not found!');
        }


        if (isset($place) && !empty($place) && !isUserAdmin()) {
            abort_if($place->user_id !== Auth::id(), 401);
        }

        if (isset($place->products)) {
            foreach ($place->products as $menu) {
                if ($menu['discount_start_date']) {
                    $menu['discount_start_date_formatted'] = Carbon::parse($menu['discount_start_date'])->format('Y-m-d');
                } else {
                    $menu['discount_start_date_formatted'] = "";
                }
                if ($menu['discount_end_date']) {
                    $menu['discount_end_date_formatted'] = Carbon::parse($menu['discount_end_date'])->format('Y-m-d');
                } else {
                    $menu['discount_end_date_formatted'] = "";
                }
            }
        }
        if (isset($place) && empty($place->reward_link) && $slug != null) {
            Place::generatePlaceRewardLink($place->id);
        }

        $place_id =  isset($place->id) ? $place->id : null ;
        $country_id = isset($place->country_id) ? $place->country_id : false;

        $countries = $this->country->getFullList();
        $cities = $this->city->getListByCountry($country_id);
        $categories = $this->category->getAllCategories(Category::TYPE_PLACE, ['id', 'name', 'pricing_text', 'icon_map_marker','slug']);
        $sub_categories = array();
        if (isset($place->category) && $slug != null) {
            $sub_categories = Category::getSubCategories($place->category);
        }

        $place_types = Category::query()
            ->with('place_type')
            ->get();
        $interests = Category::query()
            ->with('interest')
            ->get();

        $place_keyword = PlaceInterest::query()
            ->where('place_id', $place_id)
            ->pluck('interest_id')
            ->toArray();

        $amenities = $this->amenities->getListAll();

        $app_name = setting('app_name', 'Venture New Zealand');
        SEOMeta("Add new place - {$app_name}");
        $PRICING_TEXT = Category::PRICING_TEXT;
        return view('frontend.place.place_addnew', [
            'place' => $place,
            'countries' => $countries,
            'cities' => $cities,
            'categories' => $categories,
            'place_types' => $place_types,
            'amenities' => $amenities,
            'sub_categories' => $sub_categories,
            'interests' => $interests,
            'place_keyword' => $place_keyword,
            'PRICING_TEXT' => $PRICING_TEXT,
            'user_info' => $user_info,
            'operator_place' => $operator_place
        ]);
    }

    public function create(Request $request)
    {
        $request['user_id'] = Auth::id();
        // $request['slug'] = getSlug($request, 'name');
        $request['slug'] = Place::createSlug($request->en['name']);
        $request['status'] = Place::STATUS_PENDING;

        $rule_factory = RuleFactory::make([
            'user_id' => '',
            'country_id' => '',
            'city_id' => '',
            'category' => '',
            'category_name' => '',
            'sub_category' => '',
            'place_type' => '',
            '%name%' => '',
            'slug' => '',
            '%description%' => '',
            '%needtobring%' => '',
            'price_range' => '',
            'amenities' => '',
            'address' => '',
            'lat' => '',
            'lng' => '',
            'email' => '',
            'phone_number' => '',
            'website' => '',
            'social' => '',
            'opening_hour' => '',
            'gallery' => '',
            'video' => '',
            'link_bookingcom' => '',
            'status' => '',
            'thumb' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'logo' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'menu' => '',
            'booking_link' => '',
            'booking_type' => '',
            'hide_info' => '',
            'interest' => '',
        ]);

        if (!$request->has('hide_info')) {
            $request->merge(['hide_info' => 0]);
        }
        $data = $this->validate($request, $rule_factory);

        if (!isset($data['menu'])) {
            $data['menu'] = null;
        }


        if ($request->hasFile('thumb')) {
            $thumb = $request->file('thumb');
            $thumb_file = $this->uploadImage($thumb, '');
            $data['thumb'] = $thumb_file;
        }
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logo_file = $this->uploadImage($logo, '');
            $data['logo'] = $logo_file;
        }

        $model = new Place();
        $model->fill($data);
        if ($model->save()) {

            if (!isset($model->reward_link)) {
                Place::generatePlaceRewardLink($model->id);
            }

            $is_limited_products = setting(Place::DB_SETTING_KEY_IS_PLACE_PRODUCTS_LIMITED_FOR_OPERATOR);
            $max_product_allowed = setting(Place::DB_SETTING_KEY_PLACE_PRODUCTS_LIMIT_FOR_OPERATOR);

            $is_limited_featured_products = setting(Place::DB_SETTING_KEY_IS_PLACE_FEATURED_PRODUCTS_LIMITED_FOR_OPERATOR);
            $max_featured_product_allowed = setting(Place::DB_SETTING_KEY_PLACE_FEATURED_PRODUCTS_LIMIT_FOR_OPERATOR);
            if ($request->has('menu')) {
                $featuredProducts = count(array_column($request->menu, 'featured'));
                // dd($featuredProducts);
                if ($is_limited_featured_products == Place::LIMITED && $featuredProducts > $max_featured_product_allowed) {
                    return redirect(route('place_edit', $model->slug))->with('error', 'Only ' . $max_featured_product_allowed . ' product allowed to be featured!');
                }

                $insertedProductCount = 0;
                foreach ($request->menu as $menu) {
                    if(isset($menu['car_price']) && $menu['car_price'] == '' && $menu['price'] == ''){
                        return redirect(route('place_edit', $request['slug']))->with('error', 'Adult price is required');
                    }
                    if ($insertedProductCount >= $max_product_allowed && $is_limited_products == Place::LIMITED) {
                        return redirect(route('place_edit', $model->slug))->with('error', 'Product limit reached! Maximum ' . $max_product_allowed . ' products are allowed!');
                    }
                    if ($menu['name']) {
                        if (isset($menu['menu_item_id']))
                            $menu_item_id = $menu['menu_item_id'];
                        else
                            $menu_item_id = 0;
                        $menu['place_id'] = $model->id;
                        if($data['category_name'] != 'travel' && $data['slug'] == 'sealink'){
                            $menu['car_price'] = '';
                            $menu['car_discount_price'] = '';
                        }
                        PlaceProduct::updateOrCreate(['id' => $menu_item_id], $menu);
                        $insertedProductCount++;
                    }
                } //foreach
                foreach ($request->interest as $key) {
                    $interest_model = new PlaceInterest;
                    $interest_model->place_id = $model->id;
                    $interest_model->interest_id = $key;
                    $interest_model->save();
                }
            }

            return redirect(route('user_my_place'))->with('success', 'Create place success. Waiting admin review and approval!');
        }

        return $request;
    }

    public function update(Request $request)
    {
        // $request['slug'] = getSlug($request, 'name');
        // dd($request->interest);
        $request['slug'] = Place::createSlug($request->en['name'],$request->place_id);

        $rule_factory = RuleFactory::make([
            'user_id' => '',
            'country_id' => '',
            'city_id' => '',
            'category' => '',
            'category_name'=>'',
            'sub_category' => '',
            'place_type' => '',
            '%name%' => '',
            'slug' => '',
            '%description%' => '',
            '%needtobring%' => '',
            'price_range' => '',
            'amenities' => '',
            'address' => '',
            'lat' => '',
            'lng' => '',
            'email' => '',
            'phone_number' => '',
            'website' => '',
            'social' => '',
            'opening_hour' => '',
            'gallery' => '',
            'video' => '',
            'link_bookingcom' => '',
            'status' => '',
            'thumb' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'logo' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'menu' => '',
            'booking_link' => '',
            'booking_type' => '',
            'hide_info' => '',
            'interest' => '',
        ]);

        if (!$request->has('hide_info')) {
            $request->merge(['hide_info' => 0]);
        }
        $data = $this->validate($request, $rule_factory);

        if (!isset($data['menu'])) {
            $data['menu'] = null;
        }

        if ($request->hasFile('thumb')) {
            $thumb = $request->file('thumb');
            $thumb_file = $this->uploadImage($thumb, '');
            $data['thumb'] = $thumb_file;
        }
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logo_file = $this->uploadImage($logo, '');
            $data['logo'] = $logo_file;
        }
        if (!isset($data['amenities'])) {
            $data['amenities'] = '';
        }

        $model = Place::find($request->place_id);
        $model->fill($data);

        $oldkey = PLaceInterest::query()
                ->where('place_id', $request->place_id)
                ->pluck('interest_id')->toArray();
        if($request->interest == null){
            $request_keyArr = [];
        } else {
            $request_keyArr = $request->interest;
        }

        $addkey = array_diff($request_keyArr, $oldkey);
        $delkey = array_diff($oldkey, $request_keyArr);

        foreach ($addkey as $key) {
            $interest_model = new PlaceInterest;
            $interest_model->place_id = $request->place_id;
            $interest_model->interest_id = $key;
            $interest_model->save();
        }

        PlaceInterest::where('place_id', $request->place_id )
            ->whereIn('interest_id', $delkey)
            ->delete();

        $is_limited_products = setting(Place::DB_SETTING_KEY_IS_PLACE_PRODUCTS_LIMITED_FOR_OPERATOR);
        $max_product_allowed = setting(Place::DB_SETTING_KEY_PLACE_PRODUCTS_LIMIT_FOR_OPERATOR);

        $is_limited_featured_products = setting(Place::DB_SETTING_KEY_IS_PLACE_FEATURED_PRODUCTS_LIMITED_FOR_OPERATOR);
        $max_featured_product_allowed = setting(Place::DB_SETTING_KEY_PLACE_FEATURED_PRODUCTS_LIMIT_FOR_OPERATOR);

        // $user_id = auth()->user()->id;
        // $user_interest = UserInterest::where('user_id', $user_id)
        //             ->select('interest_id')
        //             ->get();
        // $user_interestArr = [];
        // foreach($user_interest as $key){
        //     $user_interestArr[] = $key->interest_id;
        // }
        // $user_fav = Wishlist::query()
        //     ->where('user_id', $user_id)
        //     ->select('place_id')
        //     ->get();
        // $user_favArr = [];
        // foreach($user_fav as $fav){
        //     $user_favArr[] = $fav->place_id;
        // }
        // $user_wish = PlaceProductWishlist::query()
        //     ->where('user_id', $user_id)
        //     ->select('place_id')
        //     ->get();
        // $user_wishArr = [];
        // foreach($user_wish as $wish){
        //     $user_wishArr[] = $wish->place_id;
        // }
        //Delete from DB What's deleted from Form
        if ($request->menu != null) {
            $menu_item_ids = array_column($request->menu, 'menu_item_id');
            PlaceProduct::where('place_id', $request->place_id)->whereNotIn('id', $menu_item_ids)->delete();

            $featuredProducts = count(array_column($request->menu, 'featured'));
            if ($is_limited_featured_products == Place::LIMITED && $featuredProducts > $max_featured_product_allowed) {
                return redirect(route('place_edit', $request['slug']))->with('error', 'Only ' . $max_featured_product_allowed . ' product allowed to be featured!');
            }

            if (count($request->menu) <= $max_product_allowed || $is_limited_products == Place::NOT_LIMITED) {
                foreach ($request->menu as $menu) {
                    if(isset($menu['car_price']) && $menu['car_price'] == '' && $menu['price'] == ''){
                        return redirect(route('place_edit', $request['slug']))->with('error', 'Adult price is required');
                    }
                    if ($menu['name']) {
                        if (isset($menu['menu_item_id']))
                            $menu_item_id = $menu['menu_item_id'];
                        else
                            $menu_item_id = 0;

                        if (!isset($menu['featured'])) {
                            $menu['featured'] = 0;
                        }
                        if (!isset($menu['online_payment_required'])) {
                            $menu['online_payment_required'] = 0;
                        }
                        $menu['place_id'] = $request->place_id;


                        // ---

                        if ($menu_item_id != 0) {
                            $placeProduct = PlaceProduct::query()
                                ->with('place')
                                ->where('id', $menu_item_id)->first();

                            if ($placeProduct->price != $menu['price']) {

                                $place = $placeProduct->place()->first();
                                $placeName = $place->name;
                                $productName = $placeProduct->name;
                                $title = 'Product updated';
                                $body = 'Product ' . $productName . '\'s price updated in ' . $placeName;
                                $image = $placeProduct->thumb;
                                WebNotification::create(
                                    [
                                        'title' => $title,
                                        'body' => $body,
                                        'image' => $image,
                                        'type' => 1, //Broadcast =1
                                        'delete_type' => 4, //Product updated = 4
                                        'place_id' => $place->id, 'product_id' => $placeProduct->id
                                    ]
                                );
                            }
                        } //$menu_item_id!=0

                        if ($menu_item_id != 0) {
                            // $placeProduct = PlaceProduct::query()->where('id',$menu_item_id)->first();

                            // if($placeProduct->booking_link!=$menu['booking_link']){

                            //     $place = $placeProduct->place()->first();
                            //     $placeName = $place->name;
                            //     $productName = $placeProduct->name;

                            //     $title = 'Product updated';
                            //     $body = 'Product '.$productName.'\'s booking link updated in '.$placeName;
                            //     $image = $placeProduct->thumb;
                            //     WebNotification::create(
                            //         ['title' => $title,
                            //         'body' => $body,
                            //         'image' => $image,
                            //         'type' => 1, //Broadcast =1
                            //         'delete_type' => 4, //Product updated = 4
                            //         'place_id' => $place->id,'product_id' => $placeProduct->id]
                            //     );
                            // }
                        } //$menu_item_id!=0




                        // ---
                        if($data['category_name'] != 'travel' && $data['slug'] == 'sealink'){
                            $menu['car_price'] = '';
                            $menu['car_discount_price'] = '';
                        }
                        PlaceProduct::updateOrCreate(['id' => $menu_item_id], $menu);
                    } //if
                } //foreach
            } else {
                return redirect(route('place_edit', $request['slug']))->with('error', 'Product limit reached! Maximum ' . $max_product_allowed . ' products are allowed!');
            }
        }



        if ($model->save()) {
            return redirect(route('user_my_place'))->with('success', 'Update place success!');
        }

        return $request;
    }

    public function getListMap(Request $request)
    {
        $city = City::find($request->city_id);

        $places = Place::query()
            ->with('categories')
            ->with('avgReview')
            ->withCount('reviews')
            ->where('city_id', $request->city_id)
            ->where('category', 'like', '%' . $request->category_id . '%')
            ->where('status', Place::STATUS_ACTIVE)
            ->get();

        $data = [
            'city' => $city,
            'places' => $places
        ];

        return $this->response->formatResponse(200, $data, 'success');
    }

    public function getListFilter(Request $request)
    {
        $city_id = $request->city_id;
        $category_id = $request->category_id;

        $sort_by = $request->sort_by;
        $price_range = $request->price;
        $place_types = $request->place_types;
        $amenities = $request->amenities;
        $filterbtn = $request->filterbtn;

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
        if($filterbtn == 'active'){
            $col = 'col-lg-4';
        }
        if($filterbtn == 'inactive'){
            $col = 'col-lg-3';
        }
        $places = Place::query()
            ->with('place_types')
            ->withCount('reviews')
            ->with('avgReview')
            ->withCount('wishList')
            ->where('city_id', $city_id)
            // ->where('category', 'like', "%$category_id%")
            ->where(function ($q) use ($category_id) {
                if ($category_id) {
                    foreach ($category_id as $key => $item) {
                        if ($key === 0) {
                            $q->where('category', 'like', "%$item%");
                        } else {
                            $q->orWhere('category', 'like', "%$item%");
                        }
                    }
                }
            })
            ->where('status', Place::STATUS_ACTIVE)
            ->where(function ($q) use ($place_types) {
                if ($place_types) {
                    foreach ($place_types as $key => $item) {
                        if ($key === 0) {
                            $q->where('place_type', 'like', "%$item%");
                        } else {
                            $q->orWhere('place_type', 'like', "%$item%");
                        }
                    }
                }
            })
            ->where(function ($q) use ($amenities) {
                if ($amenities) {
                    foreach ($amenities as $key => $item) {
                        if ($key === 0) {
                            $q->where('amenities', 'like', "%$item%");
                        } else {
                            $q->orWhere('amenities', 'like', "%$item%");
                        }
                    }
                }
            })
            ->when($price_range, function ($q, $price_range) {
                $q->where('price_range', $price_range);
            })
            ->when($sort_by, function ($q, $sort_by) {
                if ($sort_by === 'price_asc') {
                    $q->orderBy('price_range', 'asc');
                }
                if ($sort_by === 'price_desc') {
                    $q->orderBy('price_range', 'desc');
                }
            })
            ->get();
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

        // if ($price_range) {
        //     $places->where('price_range', $price_range);
        // }
        // if ($place_types) {
        //     foreach ($place_types as $place_type) {
        //         $places->where('place_type', 'like', "%$place_type%");
        //     }
        // }
        // if ($amenities) {
        //     foreach ($amenities as $item) {
        //         $places->where('amenities', 'like', "%$item%");
        //     }
        // }

        // if ($sort_by) {
        //     if ($sort_by === 'price_asc') $places->orderBy('price_range', 'asc');
        //     if ($sort_by === 'price_desc') $places->orderBy('price_range', 'desc');
        // }

        // $places = $places->get();

        $html = '<div class="divPagination row">';
        if (count($places)) :
            foreach ($places as $place) :
                $place_detail_url = route('place_detail', $place->slug);
                $place_price_range = PRICE_RANGE[$place->price_range];
                $place_thumb = getImageUrl($place->thumb);
                $logo = $place->logo != null ? getImageUrl($place->logo) : null;
                $place_price = $place->getPlacePrice();
                $category_url = getCategoryIcon($place['categories'][0]['icon_map_marker'],$place['categories'][0]['icon_map_marker']);
                $category_href = route('page_search_listing', ['category[]' => $place['categories'][0]['id']]);
                $city_listing_url = route('page_search_listing', ['city[]' => $place['city']['id']]);

                $html_place_type = "";
                foreach ($place['place_types'] as $type) :
                    $html_place_type .= "<a href='#' title='{$type->name}'> {$type->name}</a>";
                endforeach;

                if ($place->wish_list_count) {
                    $class_wishlist = "remove_wishlist active";
                } else {
                    Auth::user() ? $class_wishlist = "add_wishlist" : $class_wishlist = "open-login";
                }

                $html_review = "";
                if ($place->reviews_count) $html_review .= "{$place->avgReview} <i class='la la-star'></i>";

                $html_place_search = view('frontend.city.search_place', array(
                    'place' =>  $place
                ))->render() ;
                $html .= $html_place_search;

            //     $html .= '<div class="place-item layout-02 filterCityDiv col-md-4 col-sm-6 col-6 ' . $col . '">
            //                 <div class="flip-card">
            //                 <div class="flip-card-inner">
            //                 <div class="card-front">
            //                     <div class="place-thumb">
            //                         <div class="entry-thumb" href="' . $place_detail_url . '">
            //                             <img src="' . $place_thumb . '" alt="' . $place->name . '">
            //                             <div style="position: absolute; width: 100%; height: 100%; top: 0;background: transparent linear-gradient(180deg, #FEFEFE00 0%, #FEFEFE 100%) 0% 0% no-repeat padding-box;
            //                             opacity: 0.7; border-radius: 15px;">';
            //     if ($logo !== null){

            //         $html .='<div class="place_thumb_logo col-sm-6 col-12">
            //                     <img src="' . $logo . '" alt="logo" class="custom-img-height">
            //                 </div>
            //                 <div class="place_thumb_price_1 col-sm-6 col-12" style="background-color:' . $place['categories'][0]['color_code'] . ';">';
            //         if ($place['categories'][0]['slug'] !== "see"){
            //             $html .= '<div>
            //                         <div style="color: #FEFEFE; display:flex; justify-content:center; gap: 2px;">
            //                             <div class="treding_price_small">from</div>
            //                             <div class="treding_price_big">' . $place_price . '</div>
            //                             <div class="treding_price_small" style="align-items: end; display: flex;">NZD</div>
            //                         </div>
            //                         <div style="color: #FEFEFE; font-size:12px;">';
            //             if($place['categories'][0]['pricing_text'] !== null){
            //                 $html .= $place['categories'][0]['pricing_text'];
            //             }
            //             $html .= '</div></div>';
            //         }else{
            //             $html .= '<div style="color: #FEFEFE;" class="trending_price_free">Free</div>';
            //         }
            //         $html .= '</div>';
            //     }else{
            //         $html .='<div style="display:hidden;"></div>
            //                 <div class="place_thumb_price_1 col-sm-6 col-12" style="background-color:' . $place['categories'][0]['color_code'] . ';">';
            //         if ($place['categories'][0]['slug'] !== "see"){
            //             $html .= '<div>
            //                         <div style="color: #FEFEFE; display:flex; justify-content:center; gap: 2px;">
            //                             <div class="treding_price_small">from</div>
            //                             <div class="treding_price_big">' . $place_price . '</div>
            //                             <div class="treding_price_small" style="align-items: end; display: flex;">NZD</div>
            //                         </div>
            //                         <div style="color: #FEFEFE; font-size:12px;">';
            //             if($place['categories'][0]['pricing_text'] !== null){
            //                 $html .= $place['categories'][0]['pricing_text'];
            //             }
            //             $html .= '</div></div>';
            //         }else{
            //             $html .= '<div style="color: #FEFEFE;" class="trending_price_free">Free</div>';
            //         }
            //         $html .= '</div>';
            //     }
            //     $html .= ' </div></div>
            //     <a data-tooltip="Favourite" data-position="left" href="#"
            //                 class="golo-add-to-wishlist btn-add-to-wishlist ' . $class_wishlist . '"
            //                 data-id="{{$place->id}}" data-color="' . $place['categories'][0]['color_code'] . '"';
            //     if ($place->wish_list_count) {
            //         $html .= 'style="background-color:' . $place['categories'][0]['color_code'] . ';">
            //         <span class="icon-heart">
            //             <i class="fas fa-bookmark large"></i>
            //         </span>
            //     </a>';
            //     } else {
            //         $html .= '>
            //                 <span class="icon-heart">
            //                     <i class="far fa-bookmark large"></i>
            //                 </span>
            //             </a>';
            //     }

            //     if(isset($place['categories'][0])){
            //         $html .= '<a class="entry-category rosy-pink"
            //         href="' . $category_href . '">
            //         <img src="' . $category_url . '"
            //             alt="' . $place['categories'][0]['name'] . '" >
            //     </a>';
            //     }
            //     $html .= '</div></div>';
            //     $html .= '<div class="card-back"<div class="entry-detail">
            //     <h3 class="place-title">
            //         <a href="' . $place_detail_url . '">' . $place->name . '</a>
            //     </h3>
            //     <div class="entry-head">
            //         <div class="place-type list-item">' .
            //         $html_place_type
            //         . '</div>
            //         <div class="place-city">
            //             <a href="' . $city_listing_url . '">' . $place['city']['name'] . '</a>
            //         </div>
            //     </div>
            //     <div class="entry-bottom">
            //         <div class="place-preview">
            //             <span class="count-reviews">(' . $place->reviews_count . ' reviews)</span>
            //             <div class="place-rating">';
            //     if($place->reviews_count){
            //         for($i = 0; $i < 5 - round($place->avgReview); $i++){
            //             $html .= '<i class="far fa-star" style="color:#414141;"></i>';
            //         }
            //         for($i = 0; $i < round($place->avgReview); $i++){
            //             $html .= '<i class="fas fa-star" style="color:#febb02;"></i>';
            //         }
            //     } else{
            //         for($i = 0; $i < 5; $i++){
            //             $html .= '<i class="far fa-star" style="color:#414141;"></i>';
            //         }
            //     }
            //     $html .= '</div>
            //                 </div>
            //                 <div class="place-price">
            //                 </div>
            //             </div>
            //             <a href="' . $place_detail_url . '" class="TrendingReadMoreButton" style="background-color:' . $place['categories'][0]['color_code'] . ';">
            //             <div> Read More</div>
            //             </a>
            //         </div>
            //     </div></div>
            // </div>';

            endforeach;
        else :
            $html .= "<div class='col-md-12 text-center no_place_city'>No places</div>";
        endif;
            $html .='</div>';
        return $html;
    }

    public function migrateJSONFiledsToTable()
    {

        $places = Place::query()->get();

        foreach ($places as $place) {
            $place_id = $place->id;
            $menus = $place->menu;
            if ($menus != null) {
                foreach ($menus as $menu) {
                    if ($menu['name'] != "") {
                        $price = trim($menu['price'], '$');

                        $insert_data = array(
                            'place_id' => $place_id,
                            'name' => $menu['name'],
                            'price' => $price,
                            'description' => $menu['description'],
                            'thumb' => $menu['thumb'],
                        );

                        PlaceProduct::updateOrCreate($insert_data);
                    }
                } //foreach
            } //if
        } //foreach
        return "Look like its done";
    } //migrateJSONFiledsToTable()

    public function testNotification()
    {
        $user_id = auth()->user()->id;

        $userWishlists = \App\Models\Wishlist::where('user_id', $user_id)->get()->toArray();
        $places_ids = array_column($userWishlists, 'place_id');

        $webNotifications = \App\Models\WebNotification::whereIn('place_id', $places_ids)->orderBy('id', 'DESC')->get();
        $notificationCount = $webNotifications->count();
        $readCount = WebNotificationAction::where('user_id', $user_id)->where(function ($q) {
            $q->where('read_at', '!=', NULL)->orWhere('delete_at', '!=', NULL);
        })->count();
        $unReadCount = ($notificationCount - $readCount);


        print_r($unReadCount);
        exit;

        $query = $webNotifications->when($webNotifications, function ($q) {
        });

        return $webNotifications;
    } //testNotification()

    public function markAllNotificationsAsRead()
    {
        if (isUserHaveMembership()) {
            $user_id = auth()->user()->id;

            //Places wishlist
            $userWishlists = \App\Models\Wishlist::where('user_id', $user_id)->get()->toArray();
            $places_ids = array_column($userWishlists, 'place_id');

            //Products wishlist
            $userProductWishlists = \App\Models\PlaceProductWishlist::where('user_id', $user_id)->get()->toArray();
            $product_ids = array_column($userProductWishlists, 'product_id');


            //Get actual notification from web_notifications table
            $webNotifications = \App\Models\WebNotification::where(function ($q) use ($places_ids, $product_ids) {
                $q->whereIn('place_id', $places_ids)->OrWhereIn('product_id', $product_ids);
            })->orWhere(function ($q) use ($user_id) {
                $q->where('type', \App\Models\WebNotification::TYPE_SINGLE)->where('for_user_id', $user_id);
            })->orderBy('id', 'DESC')
                ->whereHas('web_notification_actions', function ($q) {
                    $q->where('read_at', NULL);
                    $q->where('delete_at', NULL);
                })
                ->orDoesntHave('web_notification_actions')->get();

            // $webNotifications =\App\Models\WebNotification::whereIn('place_id', $places_ids)
            //     ->whereHas('web_notification_actions',function($q){
            //         $q->where('read_at',NULL);
            //         $q->where('delete_at',NULL);
            //     })
            //     ->orDoesntHave('web_notification_actions')->get();

            foreach ($webNotifications as $row) {
                WebNotificationAction::updateOrCreate(
                    ['notification_id' => $row->id, 'user_id' => $user_id],
                    ['notification_id' => $row->id, 'user_id' => $user_id, 'read_at' => now()]
                );
            }
        }
        return redirect()->back();
    } //markAllNotificationsAsRead()

    public function genMapPinForCategory($category_id)
    {
        header("Content-type: image/png");

        $category = Category::query()->where('id', $category_id)->first();

        if ($category) {

            $iconMarkerImage = public_path("uploads/categorymarker/" . $category->id . '.png');
            $iconImage = public_path("uploads/" . $category->icon_map_marker);

            if (file_exists($iconMarkerImage)) {
                return redirect(getCategoryMapMarkerImageUrl($category->id));
            } else {

                $colorCode = $category->color_code ? $category->color_code : "#FF0000";
                $markerColorRGB = hex2rgba($colorCode);

                //Create Folder if not exists
                $folder = 'uploads/categorymarker/';
                $path = public_path($folder);
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0755, true, true);
                }

                if (!$category->icon_map_marker) {
                    $iconImage = "";
                }

                $pin = PinGenerator::getStripedPin($iconImage, [$markerColorRGB]);
                file_put_contents($iconMarkerImage, $pin);
                echo $pin;
                exit();
            }
        } else {
            return redirect(asset('assets/images/icon-mapker.png'));
        }
    } //genMapPinForCategory()

    public function featuredProducts(Request $request)
    {
        $keyword = $request->keyword;
        $filter_region = $request->region;
        $filter_city = $request->city;
        $filter_category = $request->category;
        // if($request->category){
        //     array_push($filter_category,$request->category );
        // }
        $categories = Category::query()
            ->where('type', Category::TYPE_PLACE)
            ->get();

        $region = Country::query()->get();

        if ($filter_region) {
            $cities = City::query();
            foreach ($filter_region as $key => $item) {
                if ($key === 0) {
                    $cities->where('country_id', $item);
                } else {
                    $cities->orWhere('country_id', $item);
                }
            }
            $cities = $cities->get();
        } else {
            $cities = City::query()
                ->get();
        }
        $place_products = PlaceProduct::query()
            ->with('place')
            ->withCount('placeProductWishlist')
            ->where('featured', 1)
            ->join('places', 'places.id', '=', 'place_products.place_id')
            ->when($filter_region, function ($q, $filter_region) {
                $q->whereIn('places.country_id', $filter_region);
            })
            ->when($filter_city, function ($q, $filter_city) {
                $q->whereIn('places.city_id', $filter_city);
            })
            ->where(function ($q) use ($filter_category) {
                if ($filter_category) {
                    foreach ($filter_category as $key => $item) {
                        if ($key === 0) {
                            $q->where('category', 'like', "%$item%");
                        } else {
                            $q->orWhere('category', 'like', "%$item%");
                        }
                    }
                }
            })
            ->paginate();

        $app_name = setting('app_name', 'Venture New Zealand');
        SEOMeta("Featured Products - {$app_name}");
        return view('frontend.page.featured_products', [
            'place_products' => $place_products,
            'filter_region' => $filter_region,
            'filter_city' => $filter_city,
            'filter_category' => $filter_category,
            'region' => $region,
            'cities' => $cities,
            'categories' => $categories,
        ]);
    } //featuredProducts()

    public function featuredProducts2(Request $request)
    {

        $country_id = $request->search_region;
        $city_id = $request->search_city;
        $category_id = $request->search_category;

        $filter_region = $country_id;
        $filter_city = $city_id;
        $filter_category = $category_id;

        $place_products = PlaceProduct::query()
            ->with('place')
            ->withCount('placeProductWishlist')
            ->where('featured', 1)
            ->join('places', 'places.id', '=', 'place_products.place_id')
            ->when($country_id, function ($q, $country_id) {
                $q->where('places.country_id', $country_id);
            })
            ->when($city_id, function ($q, $city_id) {
                $q->where('places.city_id', $city_id);
            })
            ->when($category_id, function ($q, $category_id) {
                $q->where('places.category', 'LIKE', '%' . $category_id . '%');
            })
            ->paginate();

        $app_name = setting('app_name', 'Venture New Zealand');
        SEOMeta("Featured Products - {$app_name}");
        return view('frontend.page.featured_products', [
            'place_products' => $place_products,
            'filter_region' => $filter_region,
            'filter_city' => $filter_city,
            'filter_category' => $filter_category,
        ]);
    } //featuredProducts()

    public function integrationRezdy(Request $request)
    {
        if (isset($request->value)) {
            $product_code = $request->value;
            $id = $request->id;
            
            $product_response = app('rezdy')->get('products/'. $product_code , [
                'query' => [
                    'apiKey' => '90ee8baf2ee0439aaf476fa2a9b6b68f'
                ]
            ]);
            $rezdy_product = json_decode($product_response->getBody(), true);

            if (isset($rezdy_product["product"])) {
                $placeProduct = PlaceProduct::find($id);
                
                if ($placeProduct) {
                    $placeProduct->product_code = $product_code;
                    $placeProduct->save();
    
                    return response()->json(['success' => true, 'message' => __('Product integrated successfully!')]);
                }
            }
            else
                return response()->json(['success' => false, 'message' => __('The product code not exist on rezdy')]);
        }
        else {
            $product_code = $request->value;
            $id = $request->id;

            $placeProduct = PlaceProduct::find($id);
                
            if ($placeProduct) {
                $placeProduct->product_code = $product_code;
                $placeProduct->save();

                return response()->json(['success' => true, 'message' => __('Product removed on rezdy successfully!')]);
            }
        }
        
        return response()->json(['success' => false, 'message' => __('Something went wrong')]);
    }

    public function productAvailability(Request $request)
    {
        $date = isset($request->date) && $request->date != "" ? date('Y-m-d',strtotime($request->date)) : null ;

        $product_id = $request->id;
        $bookingAvailibilityResult = getRezdyBookingAvailability($product_id, $date);

        if ($bookingAvailibilityResult != false) {
            return $this->response->formatResponse(200, $bookingAvailibilityResult, 'success');
        }

        $bookingAvailibilityDates = BookingAvailibility::bookingAvailibility($request->id, $request->category, null);
        if($date != null){
            $searchDate = date('Y-n-j', strtotime($date));
            if (array_search($searchDate, $bookingAvailibilityDates['date-slots']) == false) {
                return $this->response->formatResponse(200, ['slot_availibility' => []], 'success');
            }

            $bookingAvailibility = BookingAvailibility::bookingAvailibility($request->id, $request->category, $date);
            return $this->response->formatResponse(200, [
                'slot_availibility' => $bookingAvailibility['time-slots']
            ], 'success');
        }
        // $bookingAvailibility = BookingAvailibility::bookingAvailibility($request->id);

        return $this->response->formatResponse(200, [
            'availibile_dates' => $bookingAvailibilityDates['date-slots'],
            'slot_availibility' => $bookingAvailibilityDates['time-slots']
        ], 'success');

    }
}
