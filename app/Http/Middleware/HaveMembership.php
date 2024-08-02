<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\Place;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

class HaveMembership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        if ($user && $user->isAdmin() && $user->isActive()) {
            //If admin - Allow all
        } else if ($user && !isUserHaveMembership()) {
            $currentRouteName = Route::currentRouteName();
            $allowedRouteNames = array(
                'user_profile',
                'home',
                'featured_products',
                'place_detail',
                'page_search_listing',
                'ajax_search',
                'city_detail',
                'place_get_list_filter',
                'region_detail',
                'post_list_all',
                'post_detail',
                'page_contact',
                'page_contact_send',
                'user_profile_update',
                'add_to_cart',
                'cart',
                'clear_item_from_cart',
                'remove_item_from_cart',
                'booking_summary',
                'booking_history',
                'booking_details',
                'place_get_list_map',
                'show_presentation_pdf'
            );
            // dd($currentRouteName, $allowedRouteNames);
            if (!in_array($currentRouteName, $allowedRouteNames)) {
                if ($request->expectsJson() || $request->ajax()) {
                    return Response::json(["status" => false, "message" => "You need to purchase membership to access other features!", "error_code" => 101], 401);
                } else {
                    return redirect(route('user_profile'))->with('warning', 'You need to purchase membership to access other features!');
                }
            }
        } else if ($user) {

            $placeCreateLimit = setting('place_limit_for_operator');

            if ($user->user_type == User::USER_TYPE_OPERATOR && isUserHaveMembership()) {
                $myPlacesCounts = Place::getPlacesCount();
                // dd($myPlacesCounts);
                if ($myPlacesCounts == 0) {
                    //Ask to add place details
                    $currentRouteName = Route::currentRouteName();
                    $allowedRouteNames = array('place_addnew', 'place_create', 'get_sub_category', 'city_get_list');
                    if (!$user->isUserProfileComplete()) {
                        array_push($allowedRouteNames, 'user_profile');
                        array_push($allowedRouteNames, 'user_profile_update');
                    }

                    if (!$user->isUserProfileComplete() && !in_array($currentRouteName, ['user_profile', 'user_profile_update'])) {
                        return redirect(route('user_profile'))->with('error', 'Please complete your profile first!');
                    }
                    // dd("cxzcxzcxz");
                    // if (!in_array($currentRouteName, $allowedRouteNames)) {

                    //     return redirect(route('place_addnew'))->with('error', 'Please add your company info!');
                    // }
                } else if ($myPlacesCounts >= $placeCreateLimit) {
                    $currentRouteName = Route::currentRouteName();
                    $restrictedRouteNames = array('place_addnew', 'place_create');
                    if (in_array($currentRouteName, $restrictedRouteNames)) {
                        return redirect(route('user_profile'))->with('error', 'You are not allowed to access this feature!');
                    }
                }

                if ($user->user_type == User::USER_TYPE_OPERATOR && isUserHaveMembership() && $user->stripe_account_id == NULL) {
                    $currentRouteName = Route::currentRouteName();

                    $allowedRouteNames = array('place_addnew', 'place_create', 'stripe_oauthcallback', 'user_profile', 'get_sub_category', 'city_get_list');

                    if (!in_array($currentRouteName, $allowedRouteNames)) {
                        return redirect(route('user_profile'))->with('error', 'Please connect Stripe to receive bookings!');
                    }

                    if (!$user->isUserProfileComplete() && !in_array($currentRouteName, ['user_profile', 'user_profile_update'])) {
                        return redirect(route('user_profile'))->with('error', 'Please complete your profile first!');
                    }


                }
            } else if ($user->user_type == User::USER_TYPE_OPERATOR && !isUserHaveMembership()) {
                return redirect('/')->with('error', 'Please purchase a membership first!');
            }
        }
        return $next($request);
    }
}
