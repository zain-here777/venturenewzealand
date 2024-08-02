<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

class UsertypeUser
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
        else if(auth()->user()->user_type!=User::USER_TYPE_USER){
            if($request->expectsJson() || $request->ajax()){
                return Response::json(["status"=>false,"message"=>"You are not authorized to access this feature!"],401);
            }else{
                return redirect('/')->with('warning', 'You are not authorized to access that feature!');
            }
        }
        else if(auth()->user()->user_type==User::USER_TYPE_USER){
            if(!isUserHaveMembership()){
                $allowedRouteNames = array('cart');
                $currentRouteName = Route::currentRouteName();
                if (!in_array($currentRouteName, $allowedRouteNames)) {
                    if($request->expectsJson() || $request->ajax()){
                        return Response::json(["status"=>false,"message"=>"You need to purchase membership to access this feature!","error_code"=>101],401);
                    }else{
                        return redirect('/')->with('warning', 'You need to purchase membership to access this feature!');
                    }
                }
            }
        }
        return $next($request);
    }
}
