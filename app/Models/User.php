<?php

namespace App\Models;

use App\Commons\APICode;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * @property Interest[]|Collection $interests
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'google_id', 'password', 'avatar', 'phone_number', 'facebook', 'instagram',
        'country', 'state', 'city', 'suburb', 'street', 'drv_lic_no', 'drv_lic_exp', 'drv_lic_thumb',
        'passport_no', 'passport_exp', 'passport_thumb','status', 'is_admin', 'user_type', 'user_note',
        'subscription_valid_till', 'membership_renew', 'interest_mail', 'stripe_customer_id', 'stripe_account_id', 'stripe_access_token',
        'stripe_refresh_token', 'stripe_token_type','timezone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'google_id'
    ];

    protected $casts = [
        'is_admin' => 'integer',
        'status' => 'integer',
        'user_type' => 'integer',
        'membership_renew' => 'integer',
        'interest_mail' => 'integer'
    ];

    const STATUS_DEACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const USER_DEFAULT = 0;
    const USER_ADMIN = 1;

    const MEMBERSHIP_RENEW_ACTIVE = 1;
    const MEMBERSHIP_RENEW_DEACTIVE = 0;

    const INTEREST_MAIL_ACTIVE = 1;
    const INTEREST_MAIL_DEACTIVE = 0;

    public function isAdmin()
    {
        return $this->is_admin === self::USER_ADMIN;
    }

    const USER_TYPE_USER = 1;
    const USER_TYPE_OPERATOR = 2;

    const USER = 'User';
    const OPERATOR = 'Operator';

    public function isUser()
    {
        return $this->user_type === self::USER_TYPE_USER;
    }
    public function isOperator()
    {
        return $this->user_type === self::USER_TYPE_OPERATOR;
    }

    public function getUserType()
    {
        return $this->user_type == 1 ? self::USER : self::OPERATOR;
    }

    public function getUsertypeCode($usertype)
    {
        if ($usertype == "user")
            return self::USER_TYPE_USER;
        else if ($usertype == "operator")
            return self::USER_TYPE_OPERATOR;
        else
            return 0;
    }

    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isInterestMailActive()
    {
        return $this->status === self::INTEREST_MAIL_ACTIVE;
    }

    public function isMembershipRenewActive()
    {
        return $this->status === self::MEMBERSHIP_RENEW_ACTIVE;
    }

    public function validateLogin($data)
    {
        $validateData = $data->all();
        $resp = (object)[
            'code' => APICode::WRONG_PARAMS,
            'message' => ''
        ];
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];
        $message_errors = [];
        $validator = Validator::make($validateData, $rules, $message_errors);
        if ($validator->fails()) {
            $resp->message = $validator->messages();
        } else {
            $resp->code = APICode::SUCCESS;
        }
        return $resp;
    }

    public function validateRegister($data)
    {
        $validateData = $data->all();
        $resp = (object)[
            'code' => APICode::WRONG_PARAMS,
            'message' => ''
        ];
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'g-recaptcha-response' => ['required', 'captcha'],
            'user_type' => ['required', Rule::in(User::USER_TYPE_OPERATOR, User::USER_TYPE_USER)]
        ];
        $message_errors = [
            'g-recaptcha-response.required' => 'Please check the reCaptcha'
        ];
        $validator = Validator::make($validateData, $rules, $message_errors);
        if ($validator->fails()) {
            $resp->message = $validator->messages();
        } else {
            $resp->code = APICode::SUCCESS;
        }
        return $resp;
    }

    public function create($data)
    {
        $this->name = $data->name;
        $this->email = $data->email;
        $this->password = Hash::make($data->password);
        $this->user_type = $data->user_type;
        $this->save();
        return $this;
   }

    public static function getUserDetail($user_id)
    {
        $user_detail = self::find($user_id);

        return $user_detail;
    }

    public function updatePassword($data)
    {
        $user = self::find($data->user_id);
        $user->password = bcrypt($data->password_new);
        $user->save();
        return $user;
    }

    /**
     * Roll API Key
     */
    public function generateApiToken()
    {
        do {
            $this->api_token = Str::random(60);
        } while ($this->where('api_token', $this->api_token)->exists());
        $this->save();
    }

    public function generateApiToken1()
    {
        $this->api_token = Str::random(60);
        $this->save();

        return $this->api_token;
    }

    public function userSubscriptions()
    {
        return $this->hasOne(UserSubscription::class, 'user_id', 'id')->orderBy('id', 'desc');
    }


    public function applyFreeSubscription()
    {
        $freeSubscriptionEndDate = Carbon::createFromFormat('Y-m-d H:i:s', setting('operator_trial_date') . " 00:00:00");
        if ($freeSubscriptionEndDate->gt(Carbon::now()) && $this->user_type == User::USER_TYPE_OPERATOR) {
            $this->subscription_valid_till = $freeSubscriptionEndDate;
            $this->save();
            return true;
        }
        return false;
    }

    public static function isFreeSubscriptionAllow()
    {
        //dd(setting('operator_trial_date'));
        if(setting('operator_trial_date') != ''){
            $freeSubscriptionEndDate = Carbon::createFromFormat('Y-m-d H:i:s', setting('operator_trial_date') . " 00:00:00");
            if ($freeSubscriptionEndDate->gt(Carbon::now())) {
                return false;
            }
        }
        return true;
    }

    /**
     * There will always be trial days using specific date or trial_days in settings, default to 7 days
     * @return string
     */
    public static function freeSubscriptionDays(): string
    {
        $trial_period_days = '';
        $operator_trial_date = setting('operator_trial_date');
        if (isset($operator_trial_date) && Carbon::parse($operator_trial_date)->format('Y-m-d') >= Carbon::now()->format('Y-m-d')) {
            $trial_period_days = Carbon::parse(Carbon::now())->diffInDays(Carbon::parse($operator_trial_date)->format('Y-m-d')) + 1;
        } else {
            $trial_period_days = setting('operator_trial_days', '7');
        }
        return Carbon::now()->addDays($trial_period_days)->isoFormat('Do') . ' of ' . Carbon::now()->addDays($trial_period_days)->isoFormat('MMMM');
    }

    public function isUserProfileComplete()
    {
        if (
            isset($this->attributes['name']) &&
            isset($this->attributes['email']) &&
            // isset($this->attributes['avatar']) &&
            isset($this->attributes['phone_number'])
        ) {
            return true;
        }
        return false;
    }

    public static function addUserViewPlaceRecently($place_id)
    {
        $user = auth()->user();
        if (isset($user) && $user->user_type == self::USER_TYPE_USER) {
            UserViewPlace::updateOrCreate([
                'place_id' => $place_id,
                'user_id' => $user->id,
            ], [
                'view_at' => Carbon::now()
            ]);

            $count = UserViewPlace::where('user_id', $user->id)->count();
            if ($count > UserViewPlace::MAX_PLACE_VIEW_CAN_ADD) {
                $userViewPlaces = UserViewPlace::orderBy('view_at', 'desc')
                    ->skip(UserViewPlace::MAX_PLACE_VIEW_CAN_ADD)
                    ->take(PHP_INT_MAX)
                    ->get();
                foreach ($userViewPlaces as $userViewPlace) {
                    $userViewPlace->delete();
                }
            }
        }
    }

    protected static function getLocalTime($ip){ // get local timezone from user ip
        \Log::info($ip);
        // $sip = file_get_contents("http://ipecho.net/plain");
        try {
            $timezone = null;
            $url = 'http://ip-api.com/json/'.$ip;
            $response = file_get_contents($url);
            $response = json_decode($response,true);
            if($response['status'] != 'fail'){
                $timezone = $response['timezone'];
            }
        } catch (\Throwable $th) {
            return $timezone;
        }
        return $timezone;
    }

    public function interests()
    {
        return $this->hasManyThrough(Interest::class, UserInterest::class, 'user_id', 'id', 'id', 'interest_id');
    }
}
