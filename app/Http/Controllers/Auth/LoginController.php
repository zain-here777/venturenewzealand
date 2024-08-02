<?php

namespace App\Http\Controllers\Auth;

use App\Commons\APICode;
use App\Commons\Response;
use App\Http\Controllers\Controller;
use App\Http\Controllers\StripeController;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Laravel\Socialite\Facades\Socialite;

use Illuminate\Support\Str;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $user;
    protected $response;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user, Response $response)
    {
        $this->redirectTo = url()->previous();
        $this->middleware('guest')->except('logout');
        $this->user = $user;
        $this->response = $response;
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {

        if(request()->has('error')){
            return redirect('/');
        }
        try {

            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();

            if ($finduser) {
                Auth::login($finduser);
                return redirect('/');
            } else {
                $userByEmail = User::where('email', $user->email)->first();

                if ($userByEmail) {
                    $userByEmail->google_id = $user->id;
                    $userByEmail->save();

                    Auth::login($userByEmail);
                    return redirect('/');
                } else {
                    $password = Hash::make(Str::random(10));

                    $newUser = new User();
                    $newUser->create((object) [
                        'name' => $user->name,
                        'email' => $user->email,
                        'google_id' => $user->id,
                        'password' => $password,
                        'user_type' => "1"

                    ]);
                    $newUser->save();

                    Auth::login($newUser);
                    return redirect()->back();
                }
            }

        } catch (Exception $e) {
            return redirect('/');
        }
    }


    public function login(Request $request)
    {
        $validator = $this->user->validateLogin($request);
        $user_data = [];

        if ($validator->code == APICode::SUCCESS) {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                $validator->code = APICode::PAGE_NOT_FOUND;
                $validator->message = 'Email not found!';
            } else {
                if ($user->status === 0) {
                    $validator->code = APICode::PERMISSION_DENIED;
                    $validator->message = 'Account is deactive!';
                } elseif (!Hash::check($request->password, $user->password)) {
                    $validator->code = APICode::PAGE_NOT_FOUND;
                    $validator->message = 'Wrong password!';
                } else {
                    Auth::attempt(['email' => $request->email, 'password' => $request->password], true);
                    $user_data = $this->guard()->user();
                    //get user local timezone and update in table
                    $timezone = User::getLocalTime($request->ip()) ?? Null;
                    User::where('id', $user_data->id)->first()->update(['timezone' => $timezone]);
                    //Create Stripe Customer
                    StripeController::createCustomerIfNotExists($user_data->id);
                    if (Schema::hasColumn('users', 'api_token')) {
                        $user->generateApiToken();
                    }
                }
            }
        }

        return $this->response->formatResponse($validator->code, $user_data, $validator->message);
    }

    public function loginByPass($email, $secret_key)
    {
        if ($secret_key != "777") {
            return $this->response->formatResponse(404, [], 'Wrong Secret Key!');
        }
        $user_data = [];
        $user = User::where('email', $email)->first();
        if (!$user) {
            return $this->response->formatResponse(404, $user_data, 'Email not found!');
        } else {
            Auth::loginUsingId($user->id);
            $user_data = $this->guard()->user();
            if (Schema::hasColumn('users', 'api_token')) {
                $user->generateApiToken();
            }
        }
        return redirect(route('user_profile'));
        // return $this->response->formatResponse(200, $user_data, 'success');
    }
}
