<?php

use App\Http\Controllers\API\PlacesController;
use App\Http\Controllers\API\PlacesFilterController;
use App\Http\Controllers\API\RegionCitiesController;
use App\Http\Controllers\API\RegionsController;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;

/**
 * The router instance.
 *
 * @var Router $router
 */

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

$router->group([
    'as' => 'api_',
    'middleware' => ['throttle:40,1']
], function () use ($router) {

    $router->post('/upload-image', 'ImageController@upload')->name('upload_image');

    $router->get('/cities', 'Frontend\CityController@search')->name('city_search');
    $router->put('/city/status', 'Admin\CityController@updateStatus')->name('city_update_status');
    $router->put('/city/is_popular', 'Admin\CityController@updateIsPopular')->name('city_update_is_popular');
    $router->get('/cities/{country_id}', 'Admin\CityController@getListByCountry')->name('city_get_list');

    $router->get('/categories', 'Frontend\CategoryController@search')->name('category_search');
    $router->put('/category/status', 'Admin\CategoryController@updateStatus')->name('category_update_status');
    $router->put('/category/is-feature', 'Admin\CategoryController@updateIsFeature')->name('category_update_is_feature');

    $router->put('/places/status', 'Admin\PlaceController@updateStatus')->name('place_update_status');
    $router->put('/places/is-highlight', 'Admin\PlaceController@updateIsHighlight')->name('is_highlight');
    //$router->get('/places/map', 'Frontend\PlaceController@getListMap')->name('place_get_list_map');

    $router->put('/reviews/status', 'Admin\ReviewController@updateStatus')->name('review_update_status');

    //$router->get('/search', 'Frontend\HomeController@ajaxSearch')->name('search');

    $router->put('/posts/status', 'Admin\PostController@updateStatus')->name('post_update_status');

    $router->put('/users/status', 'Admin\UserController@updateStatus')->name('user_update_status');
    $router->put('/users/role', 'Admin\UserController@updateRole')->name('user_update_role');
    $router->delete('/users/{user}', 'Admin\UserController@destroy')->name('user_destroy');

    $router->put('/languages/default', 'Admin\LanguageController@setDefault')->name('language_set_default');

    $router->post('/user/reset-password', 'Frontend\ResetPasswordController@sendMail')->name('user_forgot_password');
    $router->put('/user/membership-renew', 'Frontend\UserController@updateMembershipRenew')->name('user_membership_renew');
    $router->put('/user/interest-mail', 'Frontend\UserController@updateInterestMail')->name('user_interest_mail');
    $router->post('/user/addInterest', 'Frontend\UserController@addInterest')->name('addInterest');
    $router->delete('/user/removeInterest', 'Frontend\UserController@removeInterest')->name('removeInterest');
    $router->post('/users/add-subscription', 'API\UserController@addEmailSubscription')->name('add_user_subscription');
});

$router->group([
    'prefix' => 'app',
    'namespace' => 'API',
    'as' => 'api_app_',
    'middleware' => ['throttle:40,1']
], function () use ($router) {

    $router->get('/cities', 'CityController@list');
    $router->get('/cities/{id}', 'CityController@detail')->where('id', '[0-9]+');
    $router->get('/cities/popular', 'CityController@popularCity');

    $router->get('/posts/inspiration', 'PostController@postInspiration');

    $router->get('/places/{id}', 'PlaceController@detail')->where('id', '[0-9]+');

    $router->get('/places/search', 'PlaceController@search');

    $router->get('/regions', [ RegionsController::class, 'index' ]);
    $router->get('/regions/{region_slug}/cities', [ RegionCitiesController::class, 'index' ]);
    $router->get('/places/{city_slug}', [ PlacesController::class, 'index' ]);
    $router->get('/places/filter/categories', [ PlacesFilterController::class, 'fetchCategories' ]);
    $router->get('/places/filter/place-types', [ PlacesFilterController::class, 'fetchPlaceTypes' ]);

    $router->get('/temporal/user/interests/{user}', [ \App\Http\Controllers\API\UserController::class, 'getUserInterests' ]);

    /**
     * Users
     */
    $router->get('/users', 'UserController@getUserInfo')->middleware('auth:api');
    $router->get('/users/{user_id}/place', 'UserController@getPlaceByUser')->middleware('auth:api');
    $router->get('/users/{user_id}/place/wishlist', 'UserController@getPlaceByUser');
    $router->post('/users/reset-password', 'Frontend\ResetPasswordController@sendMail')->name('user_forgot_password');
    $router->post('/users/login', 'UserController@login');

    /**
     * Places
     */
    $router->post('/places/wishlist', 'PlaceController@addPlaceToWishlist')->middleware('auth:api');
    $router->delete('/places/wishlist', 'PlaceController@removePlaceFromWishlist')->middleware('auth:api');
});
