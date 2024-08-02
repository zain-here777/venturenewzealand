<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class TempLandingController extends Controller
{
    public function index()
    {
        if (auth()->user()) {
            return redirect(route("user_profile"));
        }

        return view('frontend.landing.temp_landing');
    }
}
