<?php

namespace App\Http\Controllers\Admin;


use App\Models\City;
use App\Models\Place;
use App\Models\Country;
use App\Models\Category;
use App\Commons\Response;
use App\Models\Amenities;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PlaceProduct;
use App\Http\Controllers\Controller;
use App\Models\BookingAvailibility;
use App\Models\BookingAvailibilityTimeSlot;
use Illuminate\Support\Facades\Auth;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Support\Facades\Hash;

class PlaceController extends Controller
{
    private $place;
    private $country;
    private $city;
    private $category;
    private $amenities;
    private $response;

    public function __construct(
        Place $place,
        Country $country,
        City $city,
        Category $category,
        Amenities $amenities,
        Response $response
    ) {
        $this->place = $place;
        $this->country = $country;
        $this->city = $city;
        $this->category = $category;
        $this->amenities = $amenities;
        $this->response = $response;
    }

    public function list(Request $request)
    {
        $param_country_id = $request->country_id;
        $param_city_id = $request->city_id;
        $param_cat_id = $request->category_id;

        $places = $this->place->listByFilter($param_country_id, $param_city_id, $param_cat_id);
        $countries = $this->country->getFullList();
        $cities = $this->city->getListByCountry($param_country_id);
        $categories = $this->category->getListAll(Category::TYPE_PLACE);

        //    return $places;

        return view('admin.place.place_list', [
            'places' => $places,
            'countries' => $countries,
            'country_id' => (int)$param_country_id,
            'cities' => $cities,
            'city_id' => (int)$param_city_id,
            'categories' => $categories,
            'cat_id' => (int)$param_cat_id,
        ]);
    }

    public function createView(Request $request)
    {
        // $place = Place::find($request->id);
        $place = Place::where('id', $request->id)->with('products')->first();
        $country_id = $place ? $place->country_id : false;

        $countries = $this->country->getFullList();
        $categories = $this->category->getListAll(Category::TYPE_PLACE);
        $cities = $this->city->getListByCountry($country_id);

        $place_types = Category::query()
            ->with('place_type')
            ->get();

        $amenities = $this->amenities->getListAll();

        //        return $place;

        return view('admin.place.place_create', compact('countries', 'cities', 'categories', 'place_types', 'amenities', 'place'));
    }

    public function create(Request $request)
    {
        $request['user_id'] = Auth::id();
        $request['slug'] = getSlug($request, 'name');
        $rule_factory = RuleFactory::make([
            'add_operator' => '',
            'operator_email' => '',
            'operator_password' => '',
            'user_id' => '',
            'country_id' => '',
            'city_id' => '',
            'category' => '',
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
            'booking_type' => '',
            'link_bookingcom' => '',
            'thumb' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'seo_title' => '',
            'seo_description' => '',
            'menu' => '',
            'faq' => '',
            'hide_info' => '',
            'is_highlight' => '',
            'is_popular' => ''
        ]);

        if (!$request->has('is_popular')) {
            $request->merge(['is_popular' => 0]);
        }

        if (!$request->has('is_highlight')) {
            $request->merge(['is_highlight' => 0]);
        }

        if (!$request->has('hide_info')) {
            $request->merge(['hide_info' => 0]);
        }
        $data = $this->validate($request, $rule_factory);

        if (!isset($data['social'])) {
            $data['social'] = null;
        }

        if (!isset($data['menu'])) {
            $data['menu'] = null;
        }

        if (!isset($data['faq'])) {
            $data['faq'] = null;
        }

        if ($request->hasFile('thumb')) {
            $thumb = $request->file('thumb');
            $thumb_file = $this->uploadImage($thumb, '');
            $data['thumb'] = $thumb_file;
        }

        $model = new Place();
        $model->fill($data);

        if ($model->save()) {
            if ($request->menu) {
                foreach ($request->menu as $menu) {
                    if ($menu['name']) {
                        if (isset($menu['menu_item_id']))
                            $menu_item_id = $menu['menu_item_id'];
                        else
                            $menu_item_id = 0;
                        $menu['place_id'] = $model->id;
                        PlaceProduct::updateOrCreate(['id' => $menu_item_id], $menu);
                    } //if
                } //foreach
            }

            if (isset($data['add_operator']) && $data['add_operator'] == 1) {
                $operator = new User();
                $operator->name = '';
                $operator->email = $data['operator_email'];
                $operator->password = Hash::make($data['operator_password']);
                $operator->user_type = User::USER_TYPE_OPERATOR;
                $operator->save();
                $model->user_id = $operator->id;
                $model->save();
            }

            return redirect(route('admin_place_list'))->with('success', 'Create place success!');
        }
    }

    public function update(Request $request)
    {
        $request['slug'] = getSlug($request, 'name');
        $rule_factory = RuleFactory::make([
            'country_id' => '',
            'city_id' => '',
            'category' => '',
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
            'booking_type' => '',
            'link_bookingcom' => '',
            'thumb' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'seo_title' => '',
            'seo_description' => '',
            'menu' => '',
            'faq' => '',
            'hide_info' => '',
            'is_highlight' => '',
            'is_popular' => ''
        ]);


        if (!$request->has('is_highlight')) {
            $request->merge(['is_highlight' => 0]);
        }

        if (!$request->has('is_popular')) {
            $request->merge(['is_popular' => 0]);
        }

        if (!$request->has('hide_info')) {
            $request->merge(['hide_info' => 0]);
        }
        $data = $this->validate($request, $rule_factory);

        // dd($data);

        if (!isset($data['social'])) {
            $data['social'] = null;
        }

        if (!isset($data['menu'])) {
            $data['menu'] = null;
        }

        if (!isset($data['faq'])) {
            $data['faq'] = null;
        }

        if ($request->hasFile('thumb')) {
            $thumb = $request->file('thumb');
            $thumb_file = $this->uploadImage($thumb, '');
            $data['thumb'] = $thumb_file;
        }

        $model = Place::find($request->place_id);
        $model->fill($data);

        if ($request->menu) {
            foreach ($request->menu as $menu) {
                if ($menu['name']) {
                    if (isset($menu['menu_item_id']))
                        $menu_item_id = $menu['menu_item_id'];
                    else
                        $menu_item_id = 0;
                    $menu['place_id'] = $request->place_id;
                    PlaceProduct::updateOrCreate(['id' => $menu_item_id], $menu);
                } //if
            } //foreach
        }


        if ($model->save()) {
            return redirect(route('admin_place_list'))->with('success', 'Update place success!');
        }
    }

    public function updateStatus(Request $request)
    {
        $data = $this->validate($request, [
            'status' => 'required',
        ]);

        $model = Place::find($request->place_id);
        $model->fill($data)->save();

        return $this->response->formatResponse(200, $model, 'Update place status success!');
    }

    public function updateIsHighlight(Request $request)
    {
        $data = $this->validate($request, [
            'is_highlight' => 'required',
        ]);
        $model = Place::find($request->place_id);
        $model->fill($data)->save();
        return $this->response->formatResponse(200, $model, 'Update place highlight status success!');
    }

    public function destroy($id)
    {

        $products = PlaceProduct::where('place_id',$id)->get();
        foreach ($products as $value) {
            $bookingslot = BookingAvailibility::where('product_id',$value->id)->get();
            foreach ($bookingslot as $slots) {
                BookingAvailibilityTimeSlot::where('booking_availibility_id',$slots->id)->delete();
            }
            BookingAvailibility::where('product_id',$value->id)->delete();
        }
        PlaceProduct::where('place_id',$id)->delete();
        Place::destroy($id);
        return back()->with('success', 'Delete place success!');
    }
}
