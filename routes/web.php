<?php

use App\Mail\OperatorWelcome;
use App\Mail\UserNewBooking;
use App\Mail\UserWelcome;
use App\Models\BookingOrder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LangController;
use App\Http\Controllers\Auth\LoginController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/{any}', function () {
//     return redirect('index.html'); // You may need to adjust the view name based on your actual setup
// })->where('any', '.*');

// Auth::routes();
// $router->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$router->post('login', 'Auth\LoginController@login')->name('login');
$router->post('logout', 'Auth\LoginController@logout')->name('logout');

$router->get('set-up-profile', 'SetupProfileController@show');

// Google Signin

// Route::get('google', function () {
//     return view('googleAuth');
// });


// Google Translate

Route::get('lang/home', [LangController::class, 'index']);
Route::get('lang/change', [LangController::class, 'change'])->name('changeLang');

// Registration Routes...
$router->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$router->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
$router->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
$router->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
$router->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
$router->post('password/reset', 'Auth\ResetPasswordController@reset');

$router->group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});


$router->get('test-email', function () {
    $bookings = BookingOrder::where('id',11)->with('booking_order_items')->first();
    $emailTemplate =  new UserNewBooking([
        'name' => 'abc',
        'email' => 'abc@gmail.com',
        'phone_number' => '1234567890',
        'cart_items' => $bookings->booking_order_items,
        'total' => $bookings->booking_order_items->sum(function ($data) {
            return $data->totalPrice();
        })
    ]);
    // $emailTemplate = new UserWelcome([]);
    return Mail::to('yashpatel.tecocraft@outlook.com')->send($emailTemplate);
});


$router->get('user-welcome-email', function () {
    $emailTemplate = new UserWelcome([]);
    Mail::to('yashpatel.tecocraft@outlook.com')->send($emailTemplate);
});

$router->get('operator-welcome-email', function () {
    $emailTemplate =  new OperatorWelcome([]);
    Mail::to('yashpatel.tecocraft@outlook.com')->send($emailTemplate);
});

/**
 * Frontend Router
 */
$router->post('/product-availability', 'Frontend\PlaceController@productAvailability')->name('product-availability');
$router->group([
    'namespace' => 'Frontend',
    'middleware' => [
        'prevent-back-history',
        'haveMembership',
        'throttle:50,1'
    ]
], function () use ($router) {

    $router->get('/', 'HomeController@index')->name('home');
    // $router->get('/', 'TempLandingController@index')->name('home');
    $router->get('/language/{locale}', 'HomeController@changeLanguage')->name('change_language');
    $router->get('/search', 'HomeController@search')->name('search');

    $router->get('/blog/all', 'PostController@list')->name('post_list_all');
    $router->get('/blog/{slug}-{id}', 'PostController@detail')
        ->where('slug', '[a-zA-Z0-9-_]+')
        ->where('id', '[0-9]+')->name('post_detail');
    $router->get('/blog/{cat_slug}', 'PostController@list')->where('cat_slug', '[a-zA-Z0-9-_]+')->name('post_list');

    $router->get('/page/contact', 'HomeController@pageContact')->name('page_contact');
    $router->post('/page/contact', 'HomeController@sendContact')->name('page_contact_send');

    $router->get('/page/landing/{page_number}', 'HomeController@pageLanding')->name('page_landing');

    $router->get('/city/{slug}', 'CityController@detail')->name('city_detail');
    // $router->get('/city/{slug}/{cat_slug}', 'CityController@detail')->name('city_category_detail');

    $router->get('/region/{slug}', 'CountryController@detail')->name('region_detail');

    $router->get('/place/{slug}', 'PlaceController@detail')->name('place_detail');

    $router->post('/place/calculateprice', 'PlaceController@calculateprice')->name('calculateprice');
    $router->post('/place/integration-rezdy', 'PlaceController@integrationRezdy')->name('integration_rezdy');

    $router->get('/page/terms-and-conditions', 'HomeController@termsAndConditions')->name('page_terms_and_conditions');
    $router->get('/page/how-it-works-operator', 'HomeController@howItWorksOperator')->name('how_it_works_operator');
    $router->get('/page/how-it-works-user', 'HomeController@howItWorksUser')->name('how_it_works_user');
    $router->get('/operator-presentation', 'PdfController@showOperatorPdf')->name('show_presentation_pdf');

    $router->get('/place', function () {
        abort(404);
    });

    //Usertype Operator Middleware
    $router->group(['middleware' => ['auth', 'usertypeOperator']], function () use ($router) {
        $router->get('/new-place', 'PlaceController@pageAddNew')->name('place_addnew');
        $router->get('/edit-place/{slug}', 'PlaceController@pageAddNew')->name('place_edit');
        $router->post('/place', 'PlaceController@create')->name('place_create');
        $router->put('/place', 'PlaceController@update')->name('place_update');
        $router->get('/user/my-place', 'UserController@pageMyPlace')->name('user_my_place');
        $router->get('/user/operator', 'UserController@OprtatorList')->name('operator_list');
        $router->delete('/user/my-place', 'UserController@deleteMyPlace')->name('user_my_place_delete');
        $router->get('/booking-list', 'BookingOrderController@operatorBookingList')->name('booking_list');
        $router->post('/booking-get-previous-week', 'BookingOrderController@operatorGetpreviousweek')->name('booking_previous_week');
        $router->post('/booking-get-next-week', 'BookingOrderController@operatorGetnextweek')->name('booking_next_week');
        $router->post('/booking-get-confirmList', 'BookingOrderController@operatorGetConfirmList')->name('booking_confirm_list');
        $router->post('/booking-slot-detail', 'BookingOrderController@BookingSlotDetail')->name('booking_slot_detail');
        $router->post('/add_booking_availibility','BookingOrderController@AddBookingAvailibility')->name('add_booking_availibility');
        $router->post('/prize-update','UserController@OprtatorPrizesUpdate')->name('prize_update');
        $router->get('/booking-items/{id}', 'BookingOrderController@operatorBookingItems')->name('booking_items');
        $router->post('/load_booking_data','BookingOrderController@LoadBookingData')->name('load_booking_data');
        $router->post('delete_all_day_booking','BookingOrderController@DeleteAllDayBooking')->name('delete_all_day_booking');
        $router->post('/get_all_booking_data_by_time', 'BookingOrderController@get_all_booking_data_by_time')->name('get_all_booking_data_by_time');
        $router->post('confirm_booking','BookingOrderController@ConfirmBooking')->name('confirm_booking');
        $router->post('decline_booking','BookingOrderController@DeclineBooking')->name('decline_booking');
        $router->post('/get-reservation-details-at-opreator', 'BookingOrderController@getReservationDetailsAtOperator')->name('get.reservation.details.at.operator');
        $router->post('/get-reservation-confirm', 'BookingOrderController@getReservationConfirm')->name('get.reservation.confirm');
        $router->post('/get-reservation-cancel', 'BookingOrderController@getReservationCancel')->name('get.reservation.cancel');
    });

    //Usertype User Middleware
    $router->group(['middleware' => ['auth', 'usertypeUser']], function () use ($router) {
        $router->post('/place-follow', 'UserController@addWishlist')->name('add_wishlist');
        $router->delete('/place-follow', 'UserController@removeWishlist')->name('remove_wishlist');
        $router->get('/user/place-favourites', 'UserController@pageProfile')->name('user_wishlist');

        $router->post('/product-wishlist', 'UserController@addProductWishlist')->name('add_product_wishlist');
        $router->delete('/product-wishlist', 'UserController@removeProductWishlist')->name('remove_product_wishlist');
        $router->get('/user/product-wishlist', 'UserController@pageProfile')->name('user_product_wishlist');

        $router->any('/reward-history', 'RewardController@rewardHistory')->name('reward_history');

        $router->get('/cart', 'BookingOrderController@cartListing')->name('cart');

        $router->post('/get-reservation-details', 'BookingOrderController@getReservationDetails')->name('get.reservation.details');
    });

    ///Web Auth
    $router->get('/booking-summary', 'BookingOrderController@bookingSummary')->name('booking_summary');
    $router->post('/get-booking-by-month', 'BookingOrderController@getBookingByMonth')->name('get-booking-by-month');
    $router->post('/get-operator-booking-by-month', 'BookingOrderController@getOperatorBookingByMonth')->name('get-operator-booking-by-month');
    $router->get('/get-booking-by-day', 'BookingOrderController@getBookingByDay')->name('get-booking-by-day');
    $router->get('/get-operator-booking-by-day', 'BookingOrderController@getgetOperatorBookingByDay')->name('get-operator-booking-by-day');
    $router->post('/add-to-cart', 'BookingOrderController@addItemToCart')->name('add_to_cart');
    $router->post('/remove-item-from-cart', 'BookingOrderController@removeItemToCart')->name('remove_item_from_cart');
    $router->post('/clear-item-from-cart', 'BookingOrderController@clearItemToCart')->name('clear_item_from_cart');


    $router->get('/booking-history', 'BookingOrderController@bookingHistory')->name('booking_history');
    $router->get('/booking-details/{id}', 'BookingOrderController@bookingDetails')->name('booking_details');
    $router->put('/booking-usernote', 'BookingOrderController@addUsernote')->name('booking_usernote');


    $router->get('/featured-products', 'PlaceController@featuredProducts')->name('featured_products');

    $router->get('/reward/{reward_link}', 'RewardController@reward')->name('reward');

    //---- UNNSRY
    $router->get('/testNotification', 'PlaceController@testNotification');
    //---- UNNSRY

    $router->get('/markasread', 'PlaceController@markAllNotificationsAsRead')->name('markasread');
    $router->get('/places/filter', 'PlaceController@getListFilter')->name('place_get_list_filter');

    $router->post('/review', 'ReviewController@create')->name('review_create')->middleware('auth');

    $router->get('/category/map-pin/{id}', 'PlaceController@genMapPinForCategory');
    $router->post('/get-sub-category', 'CategoryController@subCategory')->name('get_sub_category');
    $router->post('/get-keyword', 'CategoryController@Keyword')->name('get_keyword');
    $router->post('/get-place-types', 'CategoryController@placeTypesForCategory')->name('get_place_types');


    $router->get('/user/profile', 'UserController@pageProfile')->name('user_profile')->middleware('auth');
    $router->put('/user/profile', 'UserController@updateProfile')->name('user_profile_update')->middleware('auth');
    $router->put('/user/profile/password', 'UserController@updatePassword')->name('user_password_update')->middleware('auth');
    $router->put('/user/profile/driver', 'UserController@updateDriver')->name('user_driver_update')->middleware('auth');
    $router->put('/user/profile/passport', 'UserController@updatePassport')->name('user_passport_update')->middleware('auth');
    $router->get('/user/reset-password', 'UserController@pageResetPassword')->name('user_reset_password');
    $router->put('/user/reset-password', 'ResetPasswordController@reset')->name('user_update_password');

    $router->post('/bookings', 'BookingController@booking')->name('booking_submit');

    Route::get('auth/google/redirect',  [LoginController::class, 'redirectToGoogle']);
    Route::get('auth/google/callback',  [LoginController::class, 'handleGoogleCallback'])->name('login_social_callback');
    // $router->get('/auth/{social}', 'SocialAuthController@redirect')->name('login_social');
    // $router->get('/auth/{social}/callback', 'SocialAuthController@callback')->name('login_social_callback');
    $router->post('/social_session', 'SocialAuthController@socialSession')->name('socialSession');

    $router->get('/ajax-search', 'HomeController@ajaxSearch')->name('ajax_search');
    $router->get('/ajax-search-listing', 'HomeController@searchListing');
    //$router->get('/search', 'HomeController@search')->name('search');
    $router->get('/search', 'HomeController@pageSearchListing')->name('search');
    $router->get('/places/map', 'PlaceController@getListMap')->name('place_get_list_map');

    $router->get('/cities/{country_id}', 'CityController@getListByCountry')->name('city_get_list');
    $router->get('/cities', 'CityController@search')->name('city_search');

    $router->get('/search-listing-input', 'HomeController@searchListing')->name('search_listing');
    $router->get('/search-listing', 'HomeController@pageSearchListing')->name('page_search_listing');
    // $router->get('/category/{slug}', 'CategoryController@listPlace')->name('category_list');
    $router->get('/categories', 'CategoryController@search')->name('category_search');

    $router->get('/competition_details', 'HomeController@competition_details_page')->name('competition_details');
    $router->post('/competition_participate/{competition_id}', 'HomeController@competitionParticipate')->name('competition_participate');

    $router->get('/competition_details_page', 'HomeController@competition_details_page')->name('competition_details_2');

    $router->post('/newsletter_subscribe', 'HomeController@newsletterSubscribe')->name('newsletter_subscribe');

    $router->get('/near_me', 'HomeController@nearBy')->name('near_by');
    $router->post('/near_by_places', 'HomeController@nearByPlaces')->name('near_by_places');
    $router->post('/get-subcategories-for-category', 'HomeController@getSubCategoriesForCategory')->name('get_subcategories_for_category');
});

/*
 * AdminCP Router
 */
$router->group([
    'prefix' => 'admincp',
    'namespace' => 'Admin',
    'as' => 'admin_',
    'middleware' => ['prevent-back-history', 'auth', 'auth.admin', 'throttle:50,1']
], function () use ($router) {

    $router->get('/', 'DashboardController@index')->name('dashboard');

    $router->get('/country', 'CountryController@list')->name('country_list');
    $router->post('/country', 'CountryController@create')->name('country_create');
    $router->put('/country', 'CountryController@update')->name('country_update');
    $router->delete('/country/{id}', 'CountryController@destroy')->name('country_delete');

    $router->get('/region', 'CountryController@list')->name('region_list');
    $router->post('/region', 'CountryController@create')->name('region_create');
    $router->put('/region', 'CountryController@update')->name('region_update');
    $router->delete('/region/{id}', 'CountryController@destroy')->name('region_delete');

    $router->get('/interest', 'InterestController@list')->name('interest_list');
    $router->post('/interest', 'InterestController@create')->name('interest_create');
    $router->delete('/interest/{id}', 'InterestController@destroy')->name('interest_delete');

    $router->get('/city', 'CityController@list')->name('city_list');
    $router->post('/city', 'CityController@create')->name('city_create');
    $router->put('/city', 'CityController@update')->name('city_update');
    $router->put('/city/status', 'CityController@updateStatus')->name('city_update_status');
    $router->delete('/city/{id}', 'CityController@destroy')->name('city_delete');

    $router->get('/category/{type}', 'CategoryController@list')->name('category_list');
    $router->post('/category', 'CategoryController@create')->name('category_create');
    $router->put('/category', 'CategoryController@update')->name('category_update');
    $router->delete('/category/{id}', 'CategoryController@destroy')->name('category_delete');

    $router->get('/amenities', 'AmenitiesController@list')->name('amenities_list');
    $router->post('/amenities', 'AmenitiesController@create')->name('amenities_create');
    $router->put('/amenities', 'AmenitiesController@update')->name('amenities_update');
    $router->delete('/amenities/{id}', 'AmenitiesController@destroy')->name('amenities_delete');

    // $router->get('/place-type', 'PlaceTypeController@list')->name('place_type_list');
    // $router->post('/place-type', 'PlaceTypeController@create')->name('place_type_create');
    // $router->put('/place-type', 'PlaceTypeController@update')->name('place_type_update');
    // $router->delete('/place-type/{id}', 'PlaceTypeController@destroy')->name('place_type_delete');

    $router->get('/place-type', 'SubCategoryController@list')->name('place_type_list');
    $router->post('/place-type', 'SubCategoryController@create')->name('place_type_create');
    $router->put('/place-type', 'SubCategoryController@update')->name('place_type_update');
    $router->delete('/place-type/{id}', 'SubCategoryController@destroy')->name('place_type_delete');

    $router->get('/newsletter-subscribers', 'NewsletterSubscriberController@list')->name('newsletter_subscribers_list');
    $router->delete('/newsletter_subscribe/{id}', 'NewsletterSubscriberController@destroy')->name('newsletter_subscribers_destroy');

    $router->get('/place', 'PlaceController@list')->name('place_list');
    $router->get('/place/add', 'PlaceController@createView')->name('place_create_view');
    $router->get('/place/edit/{id}', 'PlaceController@createView')->name('place_edit_view');
    $router->post('/place', 'PlaceController@create')->name('place_create');
    $router->put('/place', 'PlaceController@update')->name('place_update');
    $router->delete('/place/{id}', 'PlaceController@destroy')->name('place_delete');

    // Highlighted product
    $router->get('/highlighted-product', 'HighlightedProductController@list')->name('highlighted_product_list');
    $router->post('/highlighted-product', 'HighlightedProductController@create')->name('hl_product_create');
    $router->delete('/highlighted-product/{id}', 'HighlightedProductController@destroy')->name('hl_product_delete');

    $router->get('/competitions', 'CompetitionController@list')->name('competition_list');
    $router->get('/competition/add', 'CompetitionController@createView')->name('competition_create_view');
    $router->get('/competition/edit/{id}', 'CompetitionController@createView')->name('competition_edit_view');
    $router->post('/competition', 'CompetitionController@create')->name('competition_create');
    $router->put('/competition', 'CompetitionController@update')->name('competition_update');
    $router->delete('/competition/{id}', 'CompetitionController@destroy')->name('competition_delete');
    $router->get('/competition/participants_list/{id}', 'CompetitionController@participants_list')->name('competition_participants_list');
    $router->post('/participant/declare_winner/{id}', 'CompetitionController@participantDeclareWinner')->name('participant_declare_winner');

    $router->get('/review', 'ReviewController@list')->name('review_list');
    $router->delete('/review', 'ReviewController@destroy')->name('review_delete');

    $router->get('/users', 'UserController@list')->name('user_list');
    $router->get('/blog', 'PostController@list')->name('post_list_blog');
    $router->get('/pages', 'PostController@list')->name('post_list_page');

    $router->get('/posts/add/{type}', 'PostController@pageCreate')->name('post_add');
    $router->get('/posts/{id}', 'PostController@pageCreate')->name('post_edit');
    $router->post('/posts', 'PostController@create')->name('post_create');
    $router->put('/posts', 'PostController@update')->name('post_update');
    $router->delete('/posts/{id}', 'PostController@destroy')->name('post_delete');

    $router->get('/post-test', 'PostController@createPostTest');
    $router->get('/language/copy-folder', 'LanguageController@testCopyFolder');

    $router->get('/bookings', 'BookingController@list')->name('booking_list');
    $router->put('/bookings', 'BookingController@updateStatus')->name('booking_update_status');

    $router->get('/settings', 'SettingController@index')->name('settings');
    $router->post('/settings', 'SettingController@store')->name('setting_create');

    $router->get('/settings/language', 'SettingController@pageLanguage')->name('settings_language');
    $router->get('/settings/translation', 'SettingController@pageTranslation')->name('settings_translation');

    $router->put('/settings/language/status/{code}', 'LanguageController@updateStatus')->name('settings_language_status');
    $router->put('/settings/language/default', 'LanguageController@updateStatus')->name('settings_language_default');


    $router->get('/upgrade-to-v110', 'UpgradeController@upgradeToVersion110')->name('upgrade_v110');
    $router->get('/upgrade-to-v112', 'UpgradeController@upgradeToVersion112')->name('upgrade_v112');
    $router->get('/upgrade-to-v114', 'UpgradeController@upgradeToVersion114')->name('upgrade_v114');
    $router->get('/upgrade-to-v119', 'UpgradeController@upgradeToVersion119')->name('upgrade_v119');


    $router->get('/testimonials', 'TestimonialController@list')->name('testimonial_list');
    $router->get('/testimonials/add', 'TestimonialController@pageCreate')->name('testimonial_page_add');
    $router->get('/testimonials/edit/{id}', 'TestimonialController@pageCreate')->name('testimonial_page_edit');
    $router->post('/testimonials', 'TestimonialController@create')->name('testimonial_action');
    $router->put('/testimonials', 'TestimonialController@update')->name('testimonial_action');
    $router->delete('/testimonials/{id}', 'TestimonialController@destroy')->name('testimonial_destroy');


    $router->get('/adsbanners', 'AdsBannerController@list')->name('ads_banners');
    $router->get('/adsbanners/add', 'AdsBannerController@pageCreate')->name('adsbanners_page_add');
    $router->get('/adsbanners/edit/{id}', 'AdsBannerController@pageCreate')->name('adsbanners_page_edit');
    $router->post('/adsbanners', 'AdsBannerController@create')->name('adsbanners_action');
    $router->put('/adsbanners', 'AdsBannerController@update')->name('adsbanners_action');
    $router->delete('/adsbanners/{id}', 'AdsBannerController@destroy')->name('adsbanners_destroy');
});

$router->get('/admincp/login', 'Admin\UserController@loginPage')->name('admin_login')->middleware('throttle:10,1');

$router->get('/stripe/card', 'StripeController@card')->name('stripe_card')->middleware('auth')->middleware('throttle:10,1');
$router->post('/stripe/charge', 'StripeController@charge')->name('stripe_charge')->middleware('auth')->middleware('throttle:10,1');
$router->get('/stripe/retrieve-charge', 'StripeController@retrieveCharge')->middleware('auth')->middleware('throttle:10,1');
$router->get('/stripe/customer', 'StripeController@retrieveCustomer')->middleware('auth')->middleware('throttle:10,1');
$router->get('/stripe/retrieve-txn', 'StripeController@retrieveTxn')->middleware('auth')->middleware('throttle:10,1');

$router->post('/stripe/subscription', 'StripeController@subscriptions')->name('stripe_subscription')->middleware('auth')->middleware('throttle:10,1');
$router->get('/stripe/retrieve-sub', 'StripeController@retrieveSubscriptionStatic')->middleware('auth')->middleware('throttle:10,1');
$router->post('/stripe/webhook', 'StripeController@webhook');
$router->get('/stripe/oauthcallback', 'StripeController@oauthCallback')->name('stripe_oauthcallback');

$router->post('/stripe/charge-cart-booking', 'StripeController@chargeCartBooking')->name('stripe_charge_cart_booking')->middleware('auth')->middleware('throttle:20,1');
$router->get('/stripe/test-pic', 'StripeController@testPaymentIntentCharge')->middleware('auth');

$router->get('/stripe/retrieve-account', 'StripeController@retrieveAccount');
$router->post('stripe/validate-promo-code', 'StripeController@validatePromoCode')->name('validate_promocode');

$router->get('/stripe/cancel-subscription', 'StripeController@cancelSubscription')->name('cancel_subscription')->middleware('auth')->middleware('throttle:100,1');

$router->group(['prefix' => 'artisan', 'middleware' => ['throttle:15,1']], function () use ($router) {
    $router->get('/migrate', function () {
        Artisan::call('migrate');
        return Artisan::output();
    });

    $router->get('/rollback', function () {
        return "Disabled";
        // Artisan::call('migrate:rollback');
        // return Artisan::output();
    });

    $router->get('/clear/{options?}/{exclude?}', function ($options = 4, $exclude = 0) {
        if (($options >= 1 && $exclude != 1)) {
            Artisan::call('view:clear');
            $res[] = Artisan::output();
        }
        if (($options >= 2 && $exclude != 2)) {
            Artisan::call('cache:clear');
            $res[] = Artisan::output();
        }
        if (($options >= 3 && $exclude != 3)) {
            Artisan::call('route:clear');
            $res[] = Artisan::output();
        }
        if (($options >= 4 && $exclude != 4)) {
            Artisan::call('config:clear');
            $res[] = Artisan::output();
        }
        return $res;
    });

    //Console Commands --
    // $router->get('/fetchCityWeather', function () {
    //     Artisan::call('fetchCityWeather:fetch');
    //     return Artisan::output();
    // });
    // $router->get('/productDiscountNotification', function () {
    //     Artisan::call('productDiscountNotification:run');
    //     return Artisan::output();
    // });
    //Console Commands --

    // $router->get('/scheduleRun', function () {
    //     Artisan::call('schedule:run');
    //     return Artisan::output();
    // });

    // $router->get('/product/migrate', 'Frontend\PlaceController@migrateJSONFiledsToTable');

    // $router->get('/magic/login/{email}/{secret_key}', 'Auth\LoginController@loginByPass');

    // $router->get('/rewardLinks', function () {
    //     $places = Place::query()->where('reward_link', '!=', NULL)->limit(10)->get();
    //     foreach ($places as $place) {
    //         $url = url('/reward/' . $place['reward_link']);
    //         echo "<br><a target='_blank' href='" . $url . "'>" . $place->name . "</a>";
    //     }
    // });

    // $router->get('/genPassword', function () {
    //     return Hash::make("NewVen@2022#");
    // });
});
