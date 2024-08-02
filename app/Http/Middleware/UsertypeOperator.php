<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\Place;
use Illuminate\Support\Facades\Route;

class UsertypeOperator
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
        if(auth()->user()->isAdmin() && auth()->user()->isActive()){
            //If admin - Allow all
        }
        else if(auth()->user()->user_type==User::USER_TYPE_USER){
            return redirect('/')->with('warning', 'You are not authorized to access that page!');
        }
        else if(auth()->user()->user_type==User::USER_TYPE_OPERATOR && !isUserHaveMembership()){
            $currentRouteName = Route::currentRouteName();
            $restrictedRouteNames = array('place_addnew','place_edit','place_create','place_update');            
            if(in_array($currentRouteName,$restrictedRouteNames)){
                return redirect('/')->with('info', 'Please buy membership to add places!');
            }            
        }
        return $next($request);
    }
}
