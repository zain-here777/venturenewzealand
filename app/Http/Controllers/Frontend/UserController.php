<?php

namespace App\Http\Controllers\Frontend;


use Carbon\Carbon;
use App\Models\City;
use App\Models\User;
use App\Models\Place;
use App\Models\Category;
use App\Models\Wishlist;
use App\Commons\Response;
use App\Models\PlaceProduct;
use App\Models\PlaceType;
use App\Models\Interest;
use App\Models\UserInterest;
use App\Models\PlaceInterest;
use App\Models\Prize;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Http\Request;
use App\Models\UserSubscription;
use App\Http\Controllers\Controller;
use App\Models\BookingAvailibility;
use App\Models\BookingAvailibilityTimeSlot;
use App\Models\PlaceProductWishlist;
use App\Models\UserViewPlace;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    private $wishlist;
    private $response;

    public function __construct(Wishlist $wishlist, Response $response)
    {
        $this->wishlist = $wishlist;
        $this->response = $response;
    }

    public function addWishlist(Request $request)
    {
        $request['user_id'] = Auth::id();
        $data = $this->validate($request, [
            'user_id' => 'required',
            'place_id' => 'required',
        ]);

        $have_wishlist = Wishlist::query()
            ->where('user_id', Auth::id())
            ->where('place_id', $request->place_id)
            ->exists();

        if (!$have_wishlist) {
            $wislist = new Wishlist();
            $wislist->fill($data)->save();
            return $this->response->formatResponse(200, [], __('success'));
        } else {
            return $this->response->formatResponse(208, [], __('This place is already in your wishlist!'));
        }
    }

    public function removeWishlist(Request $request)
    {
        $request['user_id'] = Auth::id();
        $data = $this->validate($request, [
            'user_id' => 'required',
            'place_id' => 'required',
        ]);

        Wishlist::query()
            ->where('user_id', Auth::id())
            ->where('place_id', $request->place_id)
            ->delete();

        return $this->response->formatResponse(200, [], __("success"));
    }

    public function addProductWishlist(Request $request)
    {
        $request['user_id'] = Auth::id();
        $data = $this->validate($request, [
            'user_id' => 'required',
            'place_id' => 'required',
            'product_id' => 'required',
        ]);

        $have_wishlist = PlaceProductWishlist::query()
            ->where('user_id', Auth::id())
            ->where('place_id', $request->place_id)
            ->where('product_id', $request->product_id)
            ->exists();

        if (!$have_wishlist) {
            $wislist = new PlaceProductWishlist();
            $wislist->fill($data)->save();
            return $this->response->formatResponse(200, [], __("success"));
        } else {
            return $this->response->formatResponse(208, [], __("This product is already in your wishlist!"));
        }
    } //addProductWishlist()

    public function removeProductWishlist(Request $request)
    {
        $request['user_id'] = Auth::id();
        $data = $this->validate($request, [
            'user_id' => 'required',
            'place_id' => 'required',
        ]);

        PlaceProductWishlist::query()
            ->where('user_id', Auth::id())
            ->where('place_id', $request->place_id)
            ->delete();

        return $this->response->formatResponse(200, [], __("success"));
    } //removeProductWishlist()

    public function pageProductWishList()
    {
        $wishlists = PlaceProductWishlist::query()
            ->where('user_id', Auth::id())
            ->get('product_id')->toArray();

        $wishlists = array_column($wishlists, 'product_id');

        $place_products = PlaceProduct::query()
            ->whereIn('id', $wishlists)
            ->with('place')
            ->withCount('placeProductWishlist')
            ->paginate();

        $app_name = setting('app_name', 'Venture New Zealand');
        SEOMeta("Product Wishlist - {$app_name}");
        return view('frontend.user.user_product_wishlist', [
            'place_products' => $place_products
        ]);
    } //pageProductWishList()

    public function pageProfile()
    {
        // if(isUserHaveMembership()){
        //     $my_places_count = Place::getPlacesCount();
        //     if($my_places_count==0){
        //         //Ask to add place details
        //         return redirect(route('place_addnew'))->with('error','Please add your company info first!');
        //     }
        // }

        $stripe_account_connected = false;
        $stripe_connect_link_create = '';
        $stripe_connect_link_recreate = '';
        if (isUserHaveMembership()) {
            if (isOperatorUser()) {
                $user_id = Auth::user()->id;
                // -	https://dashboard.stripe.com/settings/connect/onboarding-options/oauth
                $stripe_client_id = setting("stripe_client_id");
                $state = Crypt::encryptString($user_id);

                //Express
                $stripe_connect_link_create = "https://connect.stripe.com/express/oauth/authorize?response_type=code&client_id=" . $stripe_client_id . "&state=" . $state . "&suggested_capabilities[]=transfers";
                $stripe_connect_link_recreate = "https://connect.stripe.com/express/oauth/authorize?response_type=code&client_id=" . $stripe_client_id . "&state=" . $state . "&suggested_capabilities[]=transfers";

                //Standard
                // $stripe_connect_link = "https://connect.stripe.com/oauth/authorize?response_type=code&client_id=".$stripe_client_id."&scope=read_write&state=".$state;

                $stripe_account_id = UserSubscription::getStripeAccountId();
                if ($stripe_account_id) {
                    $stripe_account_connected = true;
                }
            }
        }
        $user_id = auth()->user()->id;
        $user_info = User::where('id', $user_id)
                    ->select('id', 'name', 'avatar', 'phone_number', 'email', 'phone_number', 'user_note')
                    ->first();
        $user_subscription = UserSubscription::getSubscription();
        $user_view_places = UserViewPlace::whereHas('place')
            ->with('place')
            ->where('user_id', auth()->user()->id)
            ->orderBy('view_at', 'desc')
            ->get();
        $app_name = setting('app_name', 'Venture New Zealand');
        SEOMeta("User profile - {$app_name}");

        $wishlists = Wishlist::query()
            ->where('user_id', Auth::id())
            ->get('place_id')->toArray();

        $wishlists = array_column($wishlists, 'place_id');

        $places = Place::query()
            ->with('place_types')
            ->withCount('reviews')
            ->with('avgReview')
            ->withCount('wishList')
            ->whereIn('id', $wishlists)
            ->paginate();

        // SEOMeta("Place Followed - {$app_name}");

        $product_wishlists = PlaceProductWishlist::query()
            ->where('user_id', Auth::id())
            ->get('product_id')->toArray();

        $product_wishlists = array_column($product_wishlists, 'product_id');

        $categories = Category::query()
            ->where('categories.status', Category::STATUS_ACTIVE)
            ->where('categories.type', Category::TYPE_PLACE)
            ->where('places.status',Place::STATUS_ACTIVE)
            ->join('places', 'places.category', 'like', DB::raw("CONCAT('%', categories.id, '%')"))
            ->select('categories.id as id', 'categories.name as name', 'categories.slug as slug', 'categories.color_code as color_code', 'categories.icon_map_marker as icon_map_marker')
            ->groupBy('categories.id')
            ->orderBy('categories.priority')
            ->get();

        $place_products = PlaceProduct::query()
            ->whereIn('id', $product_wishlists)
            ->with('place')
            ->withCount('placeProductWishlist')
            ->paginate();

        $products = Place::with('products')->where('user_id',Auth::user()->id)->first();

        $interest_list = Interest:: query()
            ->with('category')
            ->get();

        $user_interest = UserInterest::query()
            ->where('user_id', $user_id)
            ->get();

        if (isUserUser()) {
            $operator_place = null;
        }
        if (isOperatorUser() && !isUserAdmin()) {
            $operator_place = Place::query()
            ->where('user_id', $user_id)
            ->first();
        }
        if (isOperatorUser() && isUserAdmin()) {
            $operator_place = Place::query()
            ->where('user_id', $user_id)
            ->get();
        }
        // SEOMeta("Product Wishlist - {$app_name}");

        return view('frontend.user.user_profile', [
            'user_info'                    => $user_info,
            'user_subscription'            => $user_subscription,
            'user_view_places'             => $user_view_places,
            'stripe_account_connected'     => $stripe_account_connected,
            'stripe_connect_link_create'   => $stripe_connect_link_create,
            'stripe_connect_link_recreate' => $stripe_connect_link_recreate,
            'places'                       => $places,
            'place_products'               => $place_products,
            'categories'                   => $categories,
            'interest_list'                => $interest_list,
            'user_interest'                => $user_interest,
            'operator_place'               => $operator_place,
            'products'                     => $products
        ]);
    }

    public function updateMembershipRenew(Request $request)
    {
        $data = $this->validate($request, [
            'membership_renew' => 'required',
        ]);

        $model = User::find($request->user_id);
        $model->fill($data);

        if ($model->save()) {
            return $this->response->formatResponse(200, $model, 'Update membership auto-renew successfully!');
        }
    }

    public function updateInterestMail(Request $request)
    {
        $data = $this->validate($request, [
            'interest_mail' => 'required',
        ]);

        $model = User::find($request->user_id);
        $model->fill($data);
        if($request->interest_mail == '1'){
            $text = 'You will receive email notifications of new listings & offers!';
        }else{
            $text = 'Email notifications of new listings & offers will not be sent to you!';
        }
        if ($model->save()) {
            return $this->response->formatResponse(200, $model, $text);
        }
    }

    public function removeInterest(Request $request)
    {
        $data = $this->validate($request, [
            'user_id' => 'required',
            'interest_id' => 'required'
        ]);
        $interest = Interest::query()
            ->where('id', $request->interest_id)
            ->first();
        $model = UserInterest::query()
            ->where('user_id', $request->user_id)
            ->where('interest_id', $request->interest_id);
        $model->delete();
        $alert = $interest->keyword . ' removed!';
        return $this->response->formatResponse(200, $model, $alert);
    }

    public function addInterest(Request $request)
    {
        $data = $this->validate($request, [
            'user_id' => 'required',
            'interest_id' => 'required'
        ]);
        $interest = Interest::query()
            ->where('id', $request->interest_id)
            ->first();
        $userinterest = new UserInterest();
        $userinterest->fill($data)->save();
        $alert = $$userinterest->keyword . ' Added!';
        return $this->response->formatResponse(200, $model, $alert);

    }

    public function pageMyPlace(Request $request)
    {
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
        $filter = [
            'city' => $request->city_id,
            'category' => $request->category_id,
            'keyword' => $request->keyword,
        ];

        // Get list places
        $places = Place::query()
            ->with('city')
            ->with('categories');
            if(Auth::user()->is_admin != User::USER_ADMIN){
                $places->where('user_id', Auth::id());
            }
            //->where('user_id', Auth::id())
            $places->where('status', '<>', Place::STATUS_DELETE)
            ->orderByDesc('id')
            ->orderByDesc('status')
            ->select(['id', 'name', 'thumb', 'slug', 'city_id', 'category', 'status']);
        if ($filter['city']) {
            $places->where('city_id', $filter['city']);
        }
        if ($filter['category']) {
            $places->where('category', 'like', '%' . $filter['category'] . '%');
        }
        if ($filter['keyword']) {
            $places->whereTranslationLike('name','%' . $filter['keyword'] . '%');
        }
        $places = $places->paginate();

        // Get list city have in places
        $city_ids = Place::query()
            ->where('user_id', Auth::id())
            ->get(['city_id', 'category'])
            ->toArray();
        $city_ids = array_column($city_ids, 'city_id');
        $cities = City::query()
            ->whereIn('id', $city_ids)
            ->get();

        // Get all categories
        $categories = Category::query()
            ->where('type', Category::TYPE_PLACE)
            ->get();

        $app_name = setting('app_name', 'Venture New Zealand');
        SEOMeta("My places - {$app_name}");
        return view('frontend.user.user_my_place', [
            'places' => $places,
            'cities' => $cities,
            'categories' => $categories,
            'filter' => $filter,
            'user_info' => $user_info,
            'operator_place' => $operator_place
        ]);
    }

    public function pageWishList()
    {
        $wishlists = Wishlist::query()
            ->where('user_id', Auth::id())
            ->get('place_id')->toArray();

        $wishlists = array_column($wishlists, 'place_id');

        $places = Place::query()
            ->with('place_types')
            ->withCount('reviews')
            ->with('avgReview')
            ->withCount('wishList')
            ->whereIn('id', $wishlists)
            ->paginate();

        $app_name = setting('app_name', 'Venture New Zealand');
        SEOMeta("Place Followed - {$app_name}");
        return view('frontend.user.user_wishlist', [
            'places' => $places
        ]);
    }

    public function pageResetPassword(Request $request)
    {
        $token = $request->token;
        return view('frontend.user.user_forgot_password', [
            'token' => $token
        ]);
    }

    public function updateProfile(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required|numeric',
            'facebook' => 'nullable',
            'instagram' => 'nullable',
            'street'=> 'nullable',
            'suburb'=> 'nullable',
            'city'=> 'nullable',
            'state'=> 'nullable',
            'country'=> 'nullable',
            'postcode'=> 'nullable',
            'avatar' => 'nullable|mimes:jpeg,jpg,png,gif|max:10240'
        ]);
        if ($request->hasFile('avatar')) {
            $icon = $request->file('avatar');
            $file_name = $this->uploadImage($icon, '');
            $data['avatar'] = $file_name;
        }

        $user = User::find(Auth::id());
        $user->fill($data)->save();

        return back()->with('success', __("Update profile success!"));
    }

    public function updateDriver(Request $request)
    {
        $data = $this->validate($request, [
            'drv_lic_no' => 'nullable',
            'drv_lic_exp' => 'nullable',
            'drv_lic_thumb' => 'nullable|mimes:jpeg,jpg,png,gif|max:10240'
        ]);

        if ($request->hasFile('drv_lic_thumb')) {
            $icon = $request->file('drv_lic_thumb');
            $file_name = $this->uploadImage($icon, '');
            $data['drv_lic_thumb'] = $file_name;
        }

        $user = User::find(Auth::id());
        $user->fill($data)->save();

        return back()->with('success', __("Update profile success!"));
    }

    public function updatePassort(Request $request)
    {
        $data = $this->validate($request, [
            'passport_no' => 'nullable',
            'passport_exp' => 'nullable',
            'passport_thumb' => 'nullable|mimes:jpeg,jpg,png,gif|max:10240'
        ]);

        if ($request->hasFile('passport_thumb')) {
            $icon = $request->file('passport_thumb');
            $file_name = $this->uploadImage($icon, '');
            $data['passport_thumb'] = $file_name;
        }

        $user = User::find(Auth::id());
        $user->fill($data)->save();

        return back()->with('success', __("Update profile success!"));
    }

    public function updatePassword(Request $request)
    {
        $user = User::find(Auth::id());

        $data = $this->validate($request, [
            'old_password' => ['required'],
            'password' => ['required'],
            'password_confirmation' => ['required'],
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', __("Wrong old password!"));
        }

        if ($request->password !== $request->password_confirmation) {
            return back()->with('error', __("Password confirm do not match!"));
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return back()->with('success', __('Change password success!'));
    }

    public function deleteMyPlace(Request $request)
    {
        //        return $request;
        $place = Place::find($request->place_id);

        if ($place->user_id !== Auth::id()) {
            return back()->with('error', __('Delete place error!'));
        }

        $place->status = Place::STATUS_DELETE;
        $place->save();

        $products = PlaceProduct::where('place_id',$request->place_id)->get();
        foreach ($products as $value) {
            $bookingslot = BookingAvailibility::where('product_id',$value->id)->get();
            foreach ($bookingslot as $slots) {
                BookingAvailibilityTimeSlot::where('booking_availibility_id',$slots->id)->delete();
            }
            BookingAvailibility::where('product_id',$value->id)->delete();
        }
        PlaceProduct::where('place_id',$request->place_id)->delete();

        return back()->with('success', __('Delete place success!'));
    }

    public function OprtatorList(Request $request)
    {
        $filter = [
            'keyword' => $request->keyword,
        ];

        // Get list places
        $operatorlist = User::query()
            ->where('is_admin','!=',User::USER_ADMIN)
            ->where('user_type',User::USER_TYPE_OPERATOR)
            ->where('status', '<>', Place::STATUS_DELETE)
            ->orderByDesc('id')
            ->select(['id', 'name','email','avatar','status','created_at']);
        if ($filter['keyword']) {
            $operatorlist->where('name', 'like', '%' . $filter['keyword'] . '%')
                        ->orWhere('email', 'like', '%' . $filter['keyword'] . '%');
        }
        $operatorlist = $operatorlist->paginate();

        $app_name = setting('app_name', 'Venture New Zealand');
        SEOMeta("Operator - {$app_name}");
        return view('frontend.user.operator_list', [
            'operatorlist' => $operatorlist,
            'filter' => $filter
        ]);
    }

    public function OprtatorPrizesUpdate(Request $request)
    {
        $rule_factory = RuleFactory::make([
            'product_id' => 'required',
            'date_from' => 'required',
            'date_to' => 'required',
            'scan_no' => 'required'
        ]);
        $data = $this->validate($request, $rule_factory);
        $data['date_from'] = date('Y-m-d',strtotime($data['date_from']));
        $data['date_to'] = date('Y-m-d',strtotime($data['date_to']));
        $prize_product_count = Prize::query()
            ->where('product_id', $data['product_id'])
            ->count();
        if($prize_product_count == 0){
            $model = new Prize();
            $model->fill($data)->save();
            $msg = 'Prize created successfully!';
        } else {
            $prize_product = Prize::query()
                ->where('product_id' ,($data['product_id']))
                ->first();
            $prize_product->fill($data)->save();
            $msg = 'Prize updated successfully!';
        }

        return back()->with('success', $msg);
    }


}
