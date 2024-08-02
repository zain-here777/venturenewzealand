<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Models\User;
use App\Services\SocialAccountService;
use Laravel\Socialite\Facades\Socialite;

use Illuminate\Http\Request;

class SocialAuthController extends Controller
{
    public function redirect($social)
    {
        return Socialite::driver($social)->redirect();
    }

    public function callback($social)
    {
        $socialUser = Socialite::driver($social)->user();
        $count = User::where('email', $socialUser->getEmail())->count();
        $user = SocialAccountService::createOrGetUser($socialUser, $social);
        // if($user->user_type != (int)session('user_type')){
        //     session()->forget('user_type');
        //     if($user->user_type == 1){
        //         $type = 'User';
        //     }else{
        //         $type = 'Operator';
        //     }
        //     return redirect('/')->with('error', 'Your are already register as a '.$type.' type.');
        // }
        if (!isset($user)) {
            // return redirect('/')->with('error', 'Your are already register as a ' . $user->getUserType() . ' type.');
            return redirect('/')->with('error', 'please sign up first');
        }
        auth()->login($user);
        session()->forget('user_type');
        request()->session()->flash('alreadyUser', $count > 0 ? false : true);
        return redirect()->route('home');
    }

    public function socialSession(Request $request)
    {
        session(['user_type' => $request->type ?? '']);
        return response()->json(['status' => true, 'data' => session('user_type')]);
    }
}
