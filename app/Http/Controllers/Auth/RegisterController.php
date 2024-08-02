<?php

namespace App\Http\Controllers\Auth;

use App\Commons\APICode;
use App\Commons\Response;
use App\Http\Controllers\Controller;
use App\Http\Controllers\StripeController;
use App\Jobs\SignUpJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserRegistration;
use App\Mail\OperatorWelcome;
use App\Mail\UserWelcome;
use App\Models\RewardPointTransaction;
use Carbon\Carbon;
use App\Services\ConvarsionService;
use Illuminate\Support\Facades\Session;
use Route;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
        $this->user = $user;
        $this->response = $response;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register(Request $request)
    {
        // dd($request->all());
        $validator = $this->user->validateRegister($request);
        if (!$request->ajax() && $validator->code !== APICode::SUCCESS) {
            return back()->withErrors($validator->message);
        }
        $user = [];
        if ($validator->code == APICode::SUCCESS) {
            $user = $this->user->create($request);
            // register to Rezdy
            if ($user->user_type == User::USER_TYPE_USER) {
                if (strpos($user->name, " ")) {
                    $first_name = substr($user->name, 0 ,strpos($user->name, " ") + 1);
                    $last_name = substr($user->name, strpos($user->name, " ") + 1, strlen($user->name) - strpos($user->name, " "));
                } else {
                    $first_name = $user->name;
                    $last_name = "";
                }
                $customerData = [
                    "email" => $user->email,
                    "firstName" => $first_name,
                    "lastName"=> $last_name,
                    "mobile" => ""
                ];
                $rezdy_response = app('rezdy')->post('customers', [
                    'json' =>$customerData,
                ]);
            }
            //Create Stripe Customer
            StripeController::createCustomerIfNotExists($user->id);
            $this->guard()->login($user);
            SignUpJob::dispatch($user);
            $user = auth()->user();

            if ($user->user_type == User::USER_TYPE_USER && $request->user_plan_type != 'free') {
                $data['user_id'] = $user->id;
                $data['transaction_type'] = 1;
                $data['title'] = 'Free Registration points';
                $data['description'] = 'You have earned 30 points.';
                $data['points'] = 30;
                $data['balance'] = 30;
                RewardPointTransaction::create($data);
            }
            if ($user->user_type == User::USER_TYPE_OPERATOR) {
                //return $this->response->formatResponse(201, $user, $validator->message);
                $user->applyFreeSubscription();
            }
            if($request->user_plan_type == 'free'){
                $user = collect($user)->merge([
                    'payment_modal' => true
                ]);
            }else{
                Session::put('paid', true);
                $user = collect($user)->merge([
                    'payment_modal' => User::isFreeSubscriptionAllow()
                ]);
            }

            if($request->user_type == 1){
                $event = 'Complete registration';
                ConvarsionService::conversionAPI($event,url('/').'/'.Route::current()->getName());
            }
        }
        request()->session()->flash('alreadyUser', true);
        if ($request->ajax()) {
            return $this->response->formatResponse($validator->code, $user, $validator->message);
        }

        return redirect('/');
    }
}
