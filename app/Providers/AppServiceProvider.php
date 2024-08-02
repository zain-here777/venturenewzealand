<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\City;
use App\Models\Place;
use App\Models\Country;
use App\Models\Category;
use App\Models\Language;
use App\Models\AdsBanner;
use App\Models\CityWeather;
use App\Models\PlaceProduct;
use App\Models\Setting;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use App\Observers\PlaceProductObserver;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        Schema::defaultStringLength(191);
        $this->forceAppScheme();

        $config = array(
            'driver' => Setting::where('name','mail_driver')->first()->val,
            'host' => Setting::where('name','mail_host')->first()->val,
            'port' => Setting::where('name','mail_port')->first()->val,
            'username' => Setting::where('name','mail_username')->first()->val,
            'password' => Setting::where('name','mail_password')->first()->val,
            'encryption' => Setting::where('name','mail_encryption')->first()->val,
            'from' => array('address' => Setting::where('name','mail_from_address')->first()->val, 'name' => Setting::where('name','mail_from_name')->first()->val),
            'sendmail' => '/usr/sbin/sendmail -bs',
            'pretend' => false,
        );
        Config::set('mail', $config);


        PlaceProduct::observe(PlaceProductObserver::class);

        $destinations = City::query()
            ->where('status', City::STATUS_ACTIVE)
            // ->limit(10)
            ->get();

        $regions = Country::query()
            ->where('status', Country::STATUS_ACTIVE)
            // ->limit(10)
            ->get();

        $popular_search_cities = Cache::remember('popular_search_cities', 60 * 60, function () {
            return City::query()
                ->inRandomOrder()
                ->limit(3)
                ->get();
        });

        if (Schema::hasTable('languages')) {
            $languages = Language::query()
                ->where('is_active', Language::STATUS_ACTIVE)
                ->orderBy('is_default', 'desc')
                ->get();

            $language_default = Language::query()
                ->where('is_default', Language::IS_DEFAULT)
                ->first();
        } else {
            $languages = [];
        }

        $city_count = City::query()
            ->where('status', City::STATUS_ACTIVE)
            ->count();

        $category_count = Category::query()
            ->where('status', Category::STATUS_ACTIVE)
            ->where('type', Category::TYPE_PLACE)
            ->count();

        $place_count = Place::query()
            ->where('status', Place::STATUS_ACTIVE)
            ->count();

        $city_weathers = CityWeather::query()->get();

        $banner_ads = AdsBanner::inRandomOrder()->limit(10)->get();

        $search_categories = Category::query()
            ->where('status', Category::STATUS_ACTIVE)
            ->where('type', Category::TYPE_PLACE)
            ->get();

        $search_place_types = Category::query()
        ->with('place_type')
        ->get();

        $search_regions = Country::query()
            ->where('status', Country::STATUS_ACTIVE)
            ->get();

        $search_cities = Country::query()
        ->where('status', Country::STATUS_ACTIVE)
        ->with('cities')
        ->get();

        View::share([
            'destinations' => $destinations,
            'regions' => $regions,
            'popular_search_cities' => $popular_search_cities,
            'languages' => $languages,
            'language_default' => $language_default,
            'city_count' => $city_count,
            'category_count' => $category_count,
            'place_count' => $place_count,
            'city_weathers' => $city_weathers,
            'banner_ads' => $banner_ads,
            'search_categories' => $search_categories,
            'search_place_types' => $search_place_types,
            'search_regions' => $search_regions,
            'search_cities' => $search_cities,
        ]);
    }

    private function forceAppScheme()
    {
        if ($this->app->environment('local')) {
            URL::forceRootUrl(env('APP_URL'));
            URL::forceScheme(parse_url( env('APP_URL'), PHP_URL_SCHEME ));
        }
    }
}
