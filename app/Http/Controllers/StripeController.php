<?php

namespace App\Http\Controllers;

use App\Models\BookingOrder;
use App\Models\Cart;
use App\Models\PlaceProduct;
use App\Models\Rezdy;
use Exception;
use Carbon\Carbon;
use Stripe\Charge;
use App\Models\User;
use Stripe\StripeClient;
use Stripe\Coupon;
use Illuminate\Http\Request;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Services\ConvarsionService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Route;

class StripeController extends Controller
{
    public static function createCustomerIfNotExists($userId)
    {
        $user = User::find($userId);
        if ($user->stripe_customer_id == NULL) {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
            $userTypePhrase = getUserTypePhrase($user->user_type);
            $customer = $stripe->customers->create([
                'description' => $user->name . ' - ' . $userTypePhrase,
                'email' => $user->email,
                'metadata' => array(
                    "userType" => $user->user_type,
                    "userTypePhrase" => $userTypePhrase
                )
            ]);
            $stripeCustomerId = $customer->id;
            $user->stripe_customer_id = $stripeCustomerId;
            $user->save();
            return true;
        }
        return false;
    } //createCustomerIfNotExists()

    public function card()
    {
        return view('frontend.stripe.card');
    }

    public function charge(Request $request)
    {
        try {
            $user = Auth::user();
            $userType = $user->user_type;

            if ($userType == 1) {
                //User
                $price = setting('subscription_price_user');
                $days = setting('subscription_days_user');
            } else if ($userType == 2) {
                //Operator
                $price = setting('subscription_price_operator');
                $days = setting('subscription_days_operator');

                $created_dates = Carbon::parse(Carbon::now())->diffInDays($user->created_at);

                if ($created_dates < $days) {
                    $price = 1;
                } else {
                    $days = 30;
                }
            }

            $description_text = $user->name . " (" . $user->email . ") purchased " . getUserTypePhrase($userType) . " membership for " . $days . " days";

            $stripeCardToken = $request->stripeToken;
            $promotion_code = null;
            if(isOperatorUser()){
                $promotion_code = $request->input('promocode');
            }
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

            $chargeParams = [
                'amount' => $price * 100,
                'currency' => 'nzd',
                'source' => $stripeCardToken ? $stripeCardToken : 'tok_visa',
                'description' => $description_text,
            ];
            $success_msg = "Membership subscribed!";
            if ($promotion_code && $promotion_code !== "") {
                $chargeParams['coupon'] = $promotion_code;
                $success_msg = "Your promo code has been applied. Membership subscribed!";
            }
            $response = $stripe->charges->create($chargeParams);
            $chargeId = $response->id;
            $txnId = $response->balance_transaction;


            UserSubscription::create([
                'user_id' => $user->id,
                'user_type' => $userType,
                'price' => $response->amount, //Stripe Amount (Price x 100)
                'days' => $days,
                'purchase_date' => date('Y-m-d H:i:s'),
                'charge_id' => $chargeId,
                'charge_status' => $response->status,
                'txn_id' => $txnId,
                'description' => $description_text,
            ]);

            $validTill = Carbon::now()->addDays($days)->format("Y-m-d H:i:s");

            $userModel = User::find($user->id);
            $userModel->subscription_valid_till = $validTill;
            $userModel->save();

            $event = 'Subscribe';
            ConvarsionService::conversionAPI($event, url('/') . '/' . Route::current()->getName());

            return redirect(route('user_profile'))->with('success', $success_msg);
        } catch (Exception $e) {
            Log::error("StripeController charge Exception: " . $e->getMessage());
            return redirect(route('user_profile'))->with('error', $e->getMessage());
        }
    }

    public function retrieveCharge()
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $charge = $stripe->charges->retrieve(
            'ch_3JrEkfSJwc8xQyys0VxNozLv',
            []
        );
        return $charge;
    }

    public function retrieveTxn()
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $txn = $stripe->balanceTransactions->retrieve(
            'txn_3JrEkfSJwc8xQyys0RQRzzv3',
            []
        );
        return $txn;
    }

    public function subscriptions(Request $request)
    {

        try {
            $user = Auth::user();
            $userType = $user->user_type;
            $stripeCustomerId = $user->stripe_customer_id;

            if ($userType == 1) {
                //User
                $priceId = setting('subscription_stripe_price_id_user');
            } else if ($userType == 2) {
                //Operator
                $priceId = setting('subscription_stripe_price_id_operator');
                // $priceId = 'price_1KBAvsKa48R4Yxezr3UP4KIt'; // LIVE
                // $priceId = 'price_1KEC0rKa48R4YxezEfEikrC8'; // TEST
            }

            // $description_text = $user->name." (".$user->email.") purchased ".getUserTypePhrase($userType)." membership for ".$days." days";

            $stripeCardToken = $request->stripeToken;
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

            //Update customer default payment method to current provided card
            $customer = $stripe->customers->update(
                $stripeCustomerId,
                ['source' => $stripeCardToken]
            );

            //If first subscription add trial days
            $lastSubIfAny = UserSubscription::getUserLastSubscription();
            if ($lastSubIfAny == null) {
                $trial_period_days = '';
                $operator_trial_date = setting('operator_trial_date');
                if (isset($operator_trial_date) && Carbon::parse($operator_trial_date)->format('Y-m-d') >= Carbon::now()->format('Y-m-d')) {
                    $trial_period_days = Carbon::parse(Carbon::now())->diffInDays(Carbon::parse($operator_trial_date)->format('Y-m-d')) + 1;
                } else {
                    $trial_period_days = setting('operator_trial_days', '7');
                }
                $subscriptionDataArray = [
                    'customer' => $stripeCustomerId,
                    'trial_period_days' => $trial_period_days,
                    'items' => [
                        ['price' => $priceId],
                    ],
                ];
            } else {
                //else not add trial days
                $subscriptionDataArray = [
                    'customer' => $stripeCustomerId,
                    'items' => [
                        ['price' => $priceId],
                    ],
                ];
            }


            //Create subscription on stripe
            $subscription = $stripe->subscriptions->create($subscriptionDataArray);

            // dd($subscription);

            $subscription_id = $subscription->id;
            $subscription_status = $subscription->status;

            $subscription_startdate = dateTimeFormat($subscription->current_period_start, 'Y-m-d H:i:s');
            $subscription_enddate = dateTimeFormat($subscription->current_period_end, 'Y-m-d H:i:s');

            $items = $subscription->items->data;

            $product_id = $items[0]->plan->product;
            $amount = $items[0]->plan->amount;
            $price_id = $items[0]->price->id;

            $plan_interval = $items[0]->plan->interval;
            $plan_interval_count = $items[0]->plan->interval_count;


            UserSubscription::create([
                'user_id' => $user->id,
                'user_type' => $userType,
                'subscription_type' => 1,
                'price' => $amount, //Stripe Amount (Price x 100)
                'purchase_date' => date('Y-m-d H:i:s'),
                'subscription_id' => $subscription_id,
                'subscription_status' => $subscription_status,
                'is_subscription_canceled' => 0,
                'subscription_startdate' => $subscription_startdate,
                'subscription_enddate' => $subscription_enddate,
                'price_id' => $price_id,
                'product_id' => $product_id
            ]);

            if ($subscription_status == "active") {

                if ($plan_interval == "year") {
                    $validTill = Carbon::now()->addYears($plan_interval_count)->format("Y-m-d H:i:s");
                } else if ($plan_interval == "month") {
                    $validTill = Carbon::now()->addMonths($plan_interval_count)->format("Y-m-d H:i:s");
                } else if ($plan_interval == "week") {
                    $validTill = Carbon::now()->addWeeks($plan_interval_count)->format("Y-m-d H:i:s");
                } else {
                    //Days
                    $validTill = Carbon::now()->addDays($plan_interval_count)->format("Y-m-d H:i:s");
                }

                $userModel = User::find($user->id);
                $userModel->subscription_valid_till = $validTill;
                $userModel->save();

                return redirect(route('user_profile'))->with('success', 'Membership subscribed!');
            } //$subscription_status
            else if ($subscription_status == "trialing") {

                $expDate = dateTimeFormat($subscription->trial_end, 'Y-m-d H:i:s');
                $validTill = $expDate;

                $userModel = User::find($user->id);
                $userModel->subscription_valid_till = $validTill;
                $userModel->save();

                return redirect(route('user_profile'))->with('success', 'Congratulations, You got a free trial! Membership subscribed!');
            }


            return redirect(route('user_profile'))->with('warning', 'Plan subscribed,Payment Incomplete');
        } catch (Exception $e) {
            Log::error("StripeController subscriptions Exception: " . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    } //subscriptions()

    public function retrieveSubscriptionStatic()
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $txn = $stripe->subscriptions->retrieve(
            'sub_1KBtyYKa48R4YxezeNHKkkiS',
            []
        );
        return $txn;
    } //retrieveSubscriptionStatic()

    public function webhook()
    {
        Log::channel('StripeWebhookLog')->info("webhook --------> about to start");
        // This is your Stripe CLI webhook secret for testing your endpoint locally.

        $db_secret = setting('stripe_webhook_secret');
//        props.set("stripe_endpoint_secret", env("STRIPE_WEBHOOK_SECRET_KEY"));

        $endpoint_secret = env("STRIPE_WEBHOOK_SECRET_KEY");
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        Log::channel('StripeWebhookLog')->error("payload:" . $payload);
        Log::channel('StripeWebhookLog')->error("sig_header:" . $sig_header);

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            Log::channel('StripeWebhookLog')->error("Invalid payload");
            Log::channel('StripeWebhookLog')->info("================================");
            // Invalid payload
            http_response_code(400);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::channel('StripeWebhookLog')->error("Invalid signature");
            Log::channel('StripeWebhookLog')->info("================================");
            // Invalid signature
            http_response_code(400);
            exit();
        }

        Log::channel('StripeWebhookLog')->info("event type : " . $event->type);

        // Handle the event
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                Log::channel('StripeWebhookLog')->error(json_encode($paymentIntent));
            case 'invoice.payment_succeeded':
                $invoice = $event->data->object;
                $paid = $invoice->paid;
                if ($paid) {
                    $subscription_id = $invoice->subscription;
                    $subscription = $this->retrieveSubscription($subscription_id);
                    Log::channel('StripeWebhookLog')->error(json_encode($subscription));

                    $subscription_id = $subscription->id;
                    $subscription_status = $subscription->status;
                    $items = $subscription->items->data;

                    $subscription_startdate = $subscription->current_period_start;
                    $subscription_enddate = $subscription->current_period_end;

                    $product_id = $items[0]->plan->product;
                    $amount = $items[0]->plan->amount;
                    $price_id = $items[0]->price->id;

                    $plan_interval = $items[0]->plan->interval;
                    $plan_interval_count = $items[0]->plan->interval_count;

                    $userModel = User::query()->where('stripe_customer_id', $subscription->customer)->first();
                    Log::channel('StripeWebhookLog')->error(json_encode($userModel));

                    UserSubscription::create([
                        'user_id' => $userModel->id,
                        'user_type' => $userModel->user_type,
                        'subscription_type' => 1,
                        'price' => $amount, //Stripe Amount (Price x 100)
                        'purchase_date' => date('Y-m-d H:i:s'),
                        'subscription_id' => $subscription_id,
                        'subscription_status' => $subscription_status,
                        'is_subscription_canceled' => 0,
                        'subscription_startdate' => $subscription_startdate,
                        'subscription_enddate' => $subscription_enddate,
                        'price_id' => $price_id,
                        'product_id' => $product_id
                    ]);

                    if ($plan_interval == "year") {
                        $validTill = Carbon::now()->addYears($plan_interval_count)->format("Y-m-d H:i:s");
                    } else if ($plan_interval == "month") {
                        $validTill = Carbon::now()->addMonths($plan_interval_count)->format("Y-m-d H:i:s");
                    } else if ($plan_interval == "week") {
                        $validTill = Carbon::now()->addWeeks($plan_interval_count)->format("Y-m-d H:i:s");
                    } else {
                        //Days
                        $validTill = Carbon::now()->addDays($plan_interval_count)->format("Y-m-d H:i:s");
                    }

                    $userModel->subscription_valid_till = $validTill;
                    $userModel->save();
                    echo "Subscription updated till:" . $validTill;
                    Log::channel('StripeWebhookLog')->info("Subscription updated till:" . $validTill);
                }
                Log::channel('StripeWebhookLog')->info(json_encode($invoice));
            default:
                Log::channel('StripeWebhookLog')->error("Received unknown event type " . $event->type);
                echo 'Received unknown event type ' . $event->type;
        }

        Log::channel('StripeWebhookLog')->info("================================");
        http_response_code(200);
    } //webhook()

    public function retrieveCustomer()
    {
        $user = Auth::user();
        $userType = $user->user_type;
        $stripeCustomerId = $user->stripe_customer_id;

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $customer = $stripe->customers->retrieve(
            $stripeCustomerId,
            []
        );
        return $customer;
    } //retrieveCustomer()

    public function retrieveSubscription($subscription_id)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $subscription = $stripe->subscriptions->retrieve(
            $subscription_id,
            []
        );
        return $subscription;
    } //retrieveSubscription()

    public function cancelSubscription()
    {
        try {
            $user = Auth::user();
            $userId = $user->id;

            $userSubscription = UserSubscription::getUserLastActiveSubscription($userId);

            if ($userSubscription) {
                $subscription_id = $userSubscription->subscription_id;

                $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
                $subscription = $stripe->subscriptions->cancel(
                    $subscription_id,
                    []
                );

                if ($subscription->status == "canceled") {
                    $userSubscription->subscription_status = $subscription->status;
                    $userSubscription->is_subscription_canceled = 1;
                    $userSubscription->save();
                    return redirect()->back()->with('success', 'Subscription canceled!');
                }
            } else {
                return redirect()->back()->with('error', 'No subscription found or subscription already canceled!');
            }
        } catch (Exception $e) {
            Log::error("StripeController subscriptions Exception: " . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    } //cancelSubscription()

    public function oauthCallback(Request $request)
    {
        try {
            $code = $request->code;
            $state = $request->state;
            $user_id = Crypt::decryptString($state);

            // if(auth()->user() && $user_id!=auth()->user()->id){
            //     return redirect(route('user_profile'))->with('error','User account mismatch!');
            // }

            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            $response = \Stripe\OAuth::token([
                'grant_type' => 'authorization_code',
                'code' => $code,
                'assert_capabilities' => ['transfers'],
            ]);

            if (!isset($response->error)) {

                $user = User::find($user_id);
                if ($user->stripe_access_token && $user->stripe_refresh_token && $user->stripe_token_type) {
                    $user->stripe_customer_id = "";
                    $user->save();
                    $this::createCustomerIfNotExists($user->id);
                }

                $user->stripe_account_id = $response->stripe_user_id;
                $user->stripe_access_token = $response->access_token;
                $user->stripe_refresh_token = $response->refresh_token;
                $user->stripe_token_type = $response->token_type;
                $user->save();

                return redirect(route('user_profile'))->with('success', 'Stripe account connected!');
            } else {
                //Error
                $error = $response->error_description;
                Log::error("StripeController oauthCallback :" . $error);
                return redirect(route('user_profile'))->with('error', $error);
            }
        } catch (Exception $e) {
            Log::error("StripeController oauthCallback Exception: " . $e->getMessage());
            return redirect(route('user_profile'))->with('error', $e->getMessage());
        }
    }

    public function retrieveAccountBalance($account_id)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $balance = \Stripe\Balance::retrieve(
            ['stripe_account' => $account_id]
        );
        return $balance;
    }

    public function retrieveAccount()
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

        $stripe->accounts->retrieve(
            'ac_Kv0SSAV0vIkkIq01Ga1nJT6NvK6cspj5',
            []
        );
    }

    public function chargeCartBooking(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'booking_phone_number' => 'required|max:15',
                'booking_email' => 'required|email',
                'booking_name' => 'required|max:50'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }
            \Log::info("======request=======");
            \Log::info($request->all());
            $user = Auth::user();
            $stripeCustomerId = $user->stripe_customer_id;
            $name = $request->booking_name;
            $email = $request->booking_email;
            $phone_number = $request->booking_phone_number;
            $description_text = $user->name . " (" . $user->email . ") Booking";
            $stripeCardToken = $request->stripeToken;
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $customer = $stripe->customers->update(   //edited
                $stripeCustomerId,
                ['source' => $stripeCardToken]
            );

            $cartItems = Cart::query()
                ->where('user_id', auth()->user()->id)
                ->get();
            Rezdy::createBooking($cartItems);
            $payable_amount = 0;
            $confirm_booking = '';
            $is_confirm = 0;
            $bookingOrder = '';
            if($cartItems->count() > 0){
                foreach ($cartItems as $cart) {
                    if($cart->confirm_booking == 1){
                        $payable_amount = Cart::getMyCartItemsPayableTotal($cart->confirm_booking,$cart->id);
                        $confirm_booking = $cart->confirm_booking;
                        $is_confirm = 1;
                    }
                }
                if($is_confirm == 1){
                    $totalpaybleamount = $payable_amount + Config::get('app.stripe_user_charge');
                    \Log::info('totalpaybleamount');
                    \Log::info($totalpaybleamount);
                    // $totalpaybleamount = number_format((float)$totalpaybleamount, 2);
                    $totalpaybleamount = number_format($totalpaybleamount, 2, '.', '');
                    \Log::info($totalpaybleamount);

                    DB::beginTransaction();
                    try {
                        //Create Booking Order and Add Items
                        $postdata['user_id'] = $user->id;
                        $postdata['name'] = $name;
                        $postdata['email'] = $email;
                        $postdata['phone_number'] = $phone_number;
                        $postdata['message'] = $description_text;
                        $postdata['total_amount'] = '';
                        if($cart->checkout_date != null){
                            $postdata['no_of_room'] = $cart->no_of_room;
                        }
                        $bookingOrder = BookingOrder::create($postdata);
                        $booking_ref_for_stripe = 'BOOKING_' . $bookingOrder->id;
                        $cartRes = Cart::moveCartItemsToBookingOrderItems($bookingOrder->id,$confirm_booking,0);
                        \Log::info('cartRes');
                        \Log::info($cartRes);
                        DB::commit();
                    } catch (\Throwable $th) {
                        \Log::info('Throwable');
                        \Log::info($th);
                        DB::rollback();
                        return redirect()->route('cart')->withErrors(['error_msg' => $th->getMessage()]);
                    }

                    // Create a PaymentIntent: Take a Card Charge
                    if($totalpaybleamount >= 0.50){

                        $paymentIntent = \Stripe\PaymentIntent::create([
                            'customer' => $stripeCustomerId,
                            'amount' => $totalpaybleamount * 100,
                            'currency' => 'nzd',
                            'payment_method_types' => ['card'],
                            'confirmation_method' =>  'automatic',
                            'capture_method' => 'automatic',  // for hold "manual", for direct pay "automatic"
                            'confirm' => true, // direct call of confimation api,
                            'transfer_group' => $booking_ref_for_stripe,
                        ]);
                        info('totalpaybleamount===============>');
                        info($totalpaybleamount);

                        // $chargeId = $paymentIntent->charges->data[0]->id;
                        //Update Payment Status
                        $bookingOrder->payable_amount = $payable_amount;
                        $bookingOrder->payment_intent_id = $paymentIntent->id;
                        $bookingOrder->payment_intent_status = $paymentIntent->status;
                        $bookingOrder->save();
                    }

                    //Distribute operator shares
                    $operators = Cart::getCartOperators($confirm_booking,0);
                    foreach ($operators as $operator) {
                        if ($operator->stripe_account_id != NULL) {
                            $place_products = PlaceProduct::query()->whereIn('id', explode(',', $operator->place_product_ids))->get();
                            // echo "<pre>";
                            // print_r($place_products);die;
                            //$place_products = PlaceProduct::query()->where('id', $operator->place_product_ids)->get();
                            $total = 0;
                            foreach ($place_products as $place_product) {
                                if ($place_product->online_payment_required == 1) {
                                    $getcartitems = Cart::where('place_product_id',$place_product->id)->where('user_id',Auth::user()->id)->first();
                                    // if(!empty($getcartitems)){
                                    $total_adult = $getcartitems->number_of_adult;
                                    $total_child = $getcartitems->number_of_children;
                                    $total_car = $getcartitems->number_of_car;
                                    $no_of_room = $getcartitems->no_of_room;

                                    if($no_of_room != null){
                                        if (checkIfOnDiscount($place_product)) {
                                            $total = ($no_of_room * checkIfOnDiscount($place_product, true));
                                        } else {
                                            $total =($no_of_room * getRezdyPrice($place_product));
                                        }

                                    }else{

                                        if (checkIfOnDiscount($place_product)) {
                                            $adult_unit_price = checkIfOnDiscount($place_product, true);
                                            $adult_total_price = $total_adult * $adult_unit_price;
                                        } else {
                                            $adult_unit_price = cleanDecimalZeros(getRezdyPrice($place_product));
                                            $adult_total_price = $total_adult * $adult_unit_price;
                                        }

                                        // CHECK DISCOUNT FOR CHILDREN
                                        if (checkIfOnChildDiscount($place_product)) {
                                            $child_unit_price = checkIfOnChildDiscount($place_product, true);
                                            $child_total_price = $total_child * $child_unit_price;
                                        } else {
                                            $child_unit_price = cleanDecimalZeros(getRezdyPrice($place_product, $place_product->child_price, 'child'));
                                            $child_total_price = $total_child * $child_unit_price;
                                        }

                                        if (checkIfOnCarDiscount($place_product)) {
                                            $car_unit_price = checkIfOnCarDiscount($place_product, true);
                                            $car_total_price = $total_car * $car_unit_price;
                                        } else {
                                            $car_unit_price = cleanDecimalZeros($place_product->car_price);
                                            $car_total_price = $total_car * $car_unit_price;
                                        }
                                        $total = $total + $adult_total_price + $child_total_price + $car_total_price;
                                    }

                                    //}
                                }
                            }

                            $commission_percentage = setting('booking_commission_percentage');
                            $commission = ($commission_percentage / 100) * $total; //0.03
                            info('commission_percentage=> '.$commission_percentage);
                            info('commission=> '.$commission);
                        // $commission = (($total * 100 * $commission_percentage) / 100);//+ 30; // + 0.30 stripe
                            $amount = cleanDecimalZeros(($total - $commission) - Config::get('app.stripe_operator_charge'));
                            // $amount = number_format($amount,2);
                            \Log::info('amount');
                            \Log::info($amount);
                            // $amount = number_format((float)$amount, 2);
                            $amount = number_format($amount, 2, '.', '');
                            info('amount=> '.$amount);
                            // Create a Transfer to a connected account (later):
                            if($amount >= 0.50){
                                $transfer = \Stripe\Transfer::create([
                                    'amount' => $amount * 100, // x 100
                                    'currency' => 'nzd',
                                    // "source_transaction" => $chargeId,
                                    'destination' => $operator->stripe_account_id,
                                    'transfer_group' => $booking_ref_for_stripe,
                                ]);
                            }
                            $cart_items = Cart::getCartItemsByOperatorId($operator->id,0);
                            $adults = $cart_items->sum('number_of_adult');
                            $childrens = $cart_items->sum('number_of_children');
                            $cars = $cart_items->sum('number_of_car');
                            $bookingDateTime = date('d-m-Y h:i A',strtotime($bookingOrder->created_at));
                            $operatorBookingDetails = [
                                'booked_at' => $bookingDateTime,
                                'date_and_time' => '',
                                'adults' => $adults,
                                'childrens' => $childrens,
                                'cars' => $cars,
                                'name' => $name,
                                'email' => $email,
                                'phone_number' => $phone_number,
                                'cart_items' => $cart_items,
                                'sub_total' => $total,
                                'transaction_charge' =>$commission,
                                'total' => ($amount / 100),
                                'send_mail_to' => $operator->email,
                            ];
                            \Log::info('operatorBookingDetails');
                            \Log::info($operatorBookingDetails);

                            //Send Booking Email to Operator
                            // dispatch(new \App\Jobs\OperatorNewBookingEmailJob($operatorBookingDetails));
                            // $operatorBookingDetails['send_mail_to'] = $email;
                            // dispatch(new \App\Jobs\OperatorNewBookingEmailJob($operatorBookingDetails));
                        }
                    }

                    $userBookingDetails = [
                        'user_id' => $user->id,
                        'name' =>  $user->name,
                        'email' => $email,
                        'phone_number' => $phone_number,
                        'cart_items' => $bookingOrder->booking_order_items,
                        'total' => $bookingOrder->booking_order_items->sum(function ($data) {
                            return $data->totalPrice();
                        }),
                        'send_mail_to' => $email
                    ];
                    \Log::info('userBookingDetails');
                    \Log::info($userBookingDetails);
                    // dispatch(new \App\Jobs\UserNewBookingEmailJob([
                    //     'user_id' => $user->id,
                    //     'name' =>  $user->name,
                    //     'email' => $email,
                    //     'phone_number' => $phone_number,
                    //     'cart_items' => $bookingOrder->booking_order_items,
                    //     'total' => $bookingOrder->booking_order_items->sum(function ($data) {
                    //         return $data->totalPrice();
                    //     }),
                    //     'send_mail_to' => $email
                    // ]));
                    // dispatch(new \App\Jobs\UserNewBookingEmailJob($userBookingDetails));
                }

                foreach ($cartItems as $cart) {
                    if($cart->confirm_booking == 0){
                        $confirm_booking = $cart->confirm_booking;
                        $payableamount = Cart::getItemsPayableTotal($cart->confirm_booking,$cart->id);

                        $totalpayble_amount = $payableamount + Config::get('app.stripe_user_charge');
                        \Log::info('totalpaybleamount');
                        \Log::info($totalpayble_amount);

                        //$totalpayble_amount = number_format($totalpayble_amount, 2, '.', '');
                        \Log::info($totalpayble_amount);

                        DB::beginTransaction();
                        try {
                            //Create Booking Order and Add Items
                            $singlepostdata['user_id'] = $user->id;
                            $singlepostdata['name'] = $name;
                            $singlepostdata['email'] = $email;
                            $singlepostdata['phone_number'] = $phone_number;
                            $singlepostdata['message'] = $description_text;
                            $singlepostdata['total_amount'] = '';
                            if($cart->checkout_date != null){
                                $singlepostdata['no_of_room'] = $cart->no_of_room;
                            }
                            $SinglebookingOrder = BookingOrder::create($singlepostdata);
                            $booking_ref_for_stripe = 'BOOKING_' . $SinglebookingOrder->id;
                            $cartRes = Cart::moveCartItemsToBookingOrderItems($SinglebookingOrder->id,$confirm_booking,$cart->id);
                            \Log::info('cartRes');
                            \Log::info($cartRes);
                            DB::commit();
                        } catch (\Throwable $th) {
                            \Log::info('Throwable');
                            \Log::info($th);
                            DB::rollback();
                            return redirect()->route('cart')->withErrors(['error_msg' => $th->getMessage()]);
                        }

                        $SinglebookingOrder->payable_amount = $payableamount;
                        if($totalpayble_amount >= 0.50){
                            $charge = \Stripe\Charge::create([
                                'amount' => $totalpayble_amount * 100,
                                'currency' => 'nzd',
                                'description' => 'Hold the payment',
                                'customer' => $customer->id,
                                'capture' => false,
                            ]);
                            $SinglebookingOrder->charge_id = $charge->id;
                        }
                        $SinglebookingOrder->payment_intent_status = 'pending';
                        $SinglebookingOrder->save();

                        $operatorsdata = Cart::getCartOperators($confirm_booking,$cart->id);
                        foreach ($operatorsdata as $operator) {
                            $place_products = PlaceProduct::query()->whereIn('id', explode(',', $operator->place_product_ids))->get();
                            //$place_products = PlaceProduct::query()->where('id', $operator->place_product_ids)->get();
                            $total = 0;
                            foreach ($place_products as $place_product) {
                                if ($place_product->online_payment_required == 1) {

                                    $getcartitems = Cart::where('place_product_id',$place_product->id)->where('user_id',Auth::user()->id)->first();
                                    // if(!empty($getcartitems)){
                                    $total_adult = $getcartitems->number_of_adult;
                                    $total_child = $getcartitems->number_of_children;
                                    $total_car = $getcartitems->number_of_car;

                                    if (checkIfOnDiscount($place_product)) {
                                        $adult_unit_price = checkIfOnDiscount($place_product, true);
                                        $adult_total_price = $total_adult * $adult_unit_price;
                                    } else {
                                        $adult_unit_price = cleanDecimalZeros(getRezdyPrice($place_product));
                                        $adult_total_price = $total_adult * $adult_unit_price;
                                    }

                                    // CHECK DISCOUNT FOR CHILDREN
                                    if (checkIfOnChildDiscount($place_product)) {
                                        $child_unit_price = checkIfOnChildDiscount($place_product, true);
                                        $child_total_price = $total_child * $child_unit_price;
                                    } else {
                                        $child_unit_price = cleanDecimalZeros(getRezdyPrice($place_product, $place_product->child_price, 'child'));
                                        $child_total_price = $total_child * $child_unit_price;
                                    }

                                    if (checkIfOnCarDiscount($place_product)) {
                                        $car_unit_price = checkIfOnCarDiscount($place_product, true);
                                        $car_total_price = $total_car * $car_unit_price;
                                    } else {
                                        $car_unit_price = cleanDecimalZeros($place_product->car_price);
                                        $car_total_price = $total_car * $car_unit_price;
                                    }
                                    $total = $total + $adult_total_price + $child_total_price + $car_total_price;
                                }
                            }

                            $commission_percentage = setting('booking_commission_percentage');
                            $commission = ($commission_percentage / 100) * $total; //0.03
                            // $commission = (($total * 100 * $commission_percentage) / 100);//+ 30; // + 0.30 stripe
                            $amount = cleanDecimalZeros(($total - $commission) - Config::get('app.stripe_operator_charge'));
                            // $amount = number_format($amount,2);
                            \Log::info('amount');
                            \Log::info($amount);
                            // $amount = number_format((float)$amount, 2);
                            $amount = number_format($amount, 2, '.', '');
                            \Log::info($amount);

                            $cart_items = Cart::getCartItemsByOperatorId($operator->id,$cart->id);
                            $adults = $cart_items->sum('number_of_adult');
                            $childrens = $cart_items->sum('number_of_children');
                            $bookingDateTime = date('d-m-Y h:i A',strtotime($SinglebookingOrder->created_at));
                            $operator_Booking_Details = [
                                'booked_at' => $bookingDateTime,
                                'date_and_time' => '',
                                'adults' => $adults,
                                'childrens' => $childrens,
                                'name' => $name,
                                'email' => $email,
                                'phone_number' => $phone_number,
                                'cart_items' => $cart_items,
                                'sub_total' => $total,
                                'transaction_charge' =>$commission,
                                'total' => ($amount / 100),
                                'send_mail_to' => $operator->email,
                            ];

                            //Send Booking Email to Operator
                            // dispatch(new \App\Jobs\OperatorNewBookingEmailJob($operator_Booking_Details));
                        }

                        // dispatch(new \App\Jobs\UserNewBookingEmailJob([
                        //     'user_id' => $user->id,
                        //     'name' =>  $user->name,
                        //     'email' => $email,
                        //     'phone_number' => $phone_number,
                        //     'cart_items' => $SinglebookingOrder->booking_order_items,
                        //     'total' => $SinglebookingOrder->booking_order_items->sum(function ($data) {
                        //         return $data->totalPrice();
                        //     }),
                        //     'send_mail_to' => $email
                        // ]));

                        $is_confirm = 0;
                    }
                }
            }

            Cart::emptyMyCart();

            if($is_confirm == 1){
                $data = array(
                    'orderID' => $bookingOrder->id,
                    'ammount' => $bookingOrder->booking_order_items->sum(function ($data) {
                        return $data->totalPrice();
                    }),
                    'qty' => count($bookingOrder->booking_order_items)
                );
                $event = 'Purchase';
                ConvarsionService::conversionAPI($event, url('/') . '/' . Route::current()->getName(), $data);
                return redirect(route('booking_details', ['id' => $bookingOrder->id]))->with('success', __('Booking success!'));
            }else{
                return redirect(route('booking_history'));
            }
        } catch (Exception $e) {
            Log::error("==========================");
            Log::error($e);
            Log::error("==========================");
            Log::error("StripeController chargeCartBooking Exception: " . $e->getMessage());
            return redirect(route('user_profile'))->with('error', $e->getMessage());
        }
    }

    public function chargeCartBooking_Old(Request $request)
    {
        try {
            $user = Auth::user();
            $stripeCustomerId = $user->stripe_customer_id;

            $name = $request->booking_name;
            $email = $request->booking_email;
            $phone_number = $request->booking_phone_number;
            $description_text = $user->name . " (" . $user->email . ") Booking";
            $stripeCardToken = $request->stripeToken;
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
            $customer = $stripe->customers->update(
                $stripeCustomerId,
                ['source' => $stripeCardToken]
            );
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            $cartItems = Cart::query()
                ->where('user_id', auth()->user()->id)
                ->get();
            $payable_amount = '';
            if($cartItems->count() > 0){
                foreach ($cartItems as $cart) {
                    if($cart->confirm_booking == 1){
                        $payable_amount = Cart::getMyCartItemsPayableTotal($cart->confirm_booking,$cart->id);
                        $totalpaybleamount = $payable_amount + Config::get('app.stripe_user_charge');
                        \Log::info('totalpaybleamount');
                        \Log::info($totalpaybleamount);
                        // $totalpaybleamount = number_format((float)$totalpaybleamount, 2);
                        $totalpaybleamount = number_format($totalpaybleamount, 2, '.', '');
                        \Log::info($totalpaybleamount);

                        DB::beginTransaction();
                        try {
                            //Create Booking Order and Add Items
                            $postdata['user_id'] = $user->id;
                            $postdata['name'] = $name;
                            $postdata['email'] = $email;
                            $postdata['phone_number'] = $phone_number;
                            $postdata['message'] = $description_text;
                            $postdata['total_amount'] = '';
                            $bookingOrder = BookingOrder::create($postdata);
                            $booking_ref_for_stripe = 'BOOKING_' . $bookingOrder->id;
                            $cartRes = Cart::moveCartItemsToBookingOrderItems($bookingOrder->id,$cart->id);
                            \Log::info('cartRes');
                            \Log::info($cartRes);
                            DB::commit();
                        } catch (\Throwable $th) {
                            \Log::info('Throwable');
                            \Log::info($th);
                            DB::rollback();
                            return redirect()->route('cart')->withErrors(['error_msg' => $th->getMessage()]);
                        }

                        // Create a PaymentIntent: Take a Card Charge
                        $paymentIntent = \Stripe\PaymentIntent::create([
                            'customer' => $stripeCustomerId,
                            'amount' => $totalpaybleamount * 100,
                            'currency' => 'nzd',
                            'payment_method_types' => ['card'],
                            'confirmation_method' =>  'automatic',
                            'capture_method' => 'automatic',  // for hold "manual", for direct pay "automatic"
                            'confirm' => true, // direct call of confimation api,
                            'transfer_group' => $booking_ref_for_stripe,
                        ]);

                        // $chargeId = $paymentIntent->charges->data[0]->id;

                        //Update Payment Status
                        $bookingOrder->payable_amount = $payable_amount;
                        $bookingOrder->payment_intent_id = $paymentIntent->id;
                        $bookingOrder->payment_intent_status = $paymentIntent->status;
                        $bookingOrder->save();

                        //Distribute operator shares
                        $operators = Cart::getCartOperators($cart->confirm_booking,$cart->id);
                        foreach ($operators as $operator) {
                            if ($operator->stripe_account_id != NULL) {
                                $place_products = PlaceProduct::query()->whereIn('id', explode(',', $operator->place_product_ids))->get();
                                //$place_products = PlaceProduct::query()->where('id', $operator->place_product_ids)->get();
                                $total = 0;
                                foreach ($place_products as $place_product) {
                                    if ($place_product->online_payment_required == 1) {

                                        $total_adult = $operator->number_of_adult;
                                        $total_child = $operator->number_of_children;

                                        // CHECK DISCOUNT FOR ADULTS
                                        if (checkIfOnDiscount($place_product)) {
                                            $adult_unit_price = checkIfOnDiscount($place_product, true);
                                            $adult_total_price = $total_adult * $adult_unit_price;
                                        } else {
                                            $adult_unit_price = cleanDecimalZeros(getRezdyPrice($place_product));
                                            $adult_total_price = $total_adult * $adult_unit_price;
                                        }

                                        // CHECK DISCOUNT FOR CHILDREN
                                        if (checkIfOnChildDiscount($place_product)) {
                                            $child_unit_price = checkIfOnChildDiscount($place_product, true);
                                            $child_total_price = $total_child * $child_unit_price;
                                        } else {
                                            $child_unit_price = cleanDecimalZeros(getRezdyPrice($place_product, $place_product->child_price, 'child'));
                                            $child_total_price = $total_child * $child_unit_price;
                                        }

                                        $total = $total + $adult_total_price + $child_total_price;


                                    }
                                }

                                $commission_percentage = setting('booking_commission_percentage');
                                $commission = ($commission_percentage / 100) * $total; //0.03
                            // $commission = (($total * 100 * $commission_percentage) / 100);//+ 30; // + 0.30 stripe
                                $amount = cleanDecimalZeros(($total - $commission) - Config::get('app.stripe_operator_charge'));
                                // $amount = number_format($amount,2);
                                \Log::info('amount');
                                \Log::info($amount);
                                // $amount = number_format((float)$amount, 2);
                                $amount = number_format($amount, 2, '.', '');
                                \Log::info($amount);
                                // Create a Transfer to a connected account (later):
                                $transfer = \Stripe\Transfer::create([
                                    'amount' => $amount * 100, // x 100
                                    'currency' => 'nzd',
                                    // "source_transaction" => $chargeId,
                                    'destination' => $operator->stripe_account_id,
                                    'transfer_group' => $booking_ref_for_stripe,
                                ]);
                                $cart_items = Cart::getCartItemsByOperatorId($operator->id);
                                $adults = $cart_items->sum('number_of_adult');
                                $childrens = $cart_items->sum('number_of_children');
                                $bookingDateTime = date('d-m-Y h:i A',strtotime($bookingOrder->created_at));
                                $operatorBookingDetails = [
                                    'booked_at' => $bookingDateTime,
                                    'date_and_time' => '',
                                    'adults' => $adults,
                                    'childrens' => $childrens,
                                    'name' => $name,
                                    'email' => $email,
                                    'phone_number' => $phone_number,
                                    'cart_items' => $cart_items,
                                    'sub_total' => $total,
                                    'transaction_charge' =>$commission,
                                    'total' => ($amount / 100),
                                    'send_mail_to' => $operator->email,
                                ];

                                //Send Booking Email to Operator
                                dispatch(new \App\Jobs\OperatorNewBookingEmailJob($operatorBookingDetails));
                                // $operatorBookingDetails['send_mail_to'] = $email;
                                // dispatch(new \App\Jobs\OperatorNewBookingEmailJob($operatorBookingDetails));
                            }
                        }

                        dispatch(new \App\Jobs\UserNewBookingEmailJob([
                            'user_id' => $user->id,
                            'name' =>  $user->name,
                            'email' => $email,
                            'phone_number' => $phone_number,
                            'cart_items' => $bookingOrder->booking_order_items,
                            'total' => $bookingOrder->booking_order_items->sum(function ($data) {
                                return $data->totalPrice();
                            }),
                            'send_mail_to' => $email
                        ]));
                    }else{
                        $payable_amount = Cart::getMyCartItemsPayableTotal($cart->confirm_booking,$cart->id);

                        $totalpaybleamount = $payable_amount + Config::get('app.stripe_user_charge');
                        \Log::info('totalpaybleamount');
                        \Log::info($totalpaybleamount);
                        // $totalpaybleamount = number_format((float)$totalpaybleamount, 2);
                        $totalpaybleamount = number_format($totalpaybleamount, 2, '.', '');
                        \Log::info($totalpaybleamount);

                        DB::beginTransaction();
                        try {
                            //Create Booking Order and Add Items
                            $postdata['user_id'] = $user->id;
                            $postdata['name'] = $name;
                            $postdata['email'] = $email;
                            $postdata['phone_number'] = $phone_number;
                            $postdata['message'] = $description_text;
                            $postdata['total_amount'] = '';
                            $bookingOrder = BookingOrder::create($postdata);
                            $booking_ref_for_stripe = 'BOOKING_' . $bookingOrder->id;
                            $cartRes = Cart::moveCartItemsToBookingOrderItems($bookingOrder->id,$cart->id);
                            \Log::info('cartRes');
                            \Log::info($cartRes);
                            DB::commit();
                        } catch (\Throwable $th) {
                            \Log::info('Throwable');
                            \Log::info($th);
                            DB::rollback();
                            return redirect()->route('cart')->withErrors(['error_msg' => $th->getMessage()]);
                        }

                        $charge = \Stripe\Charge::create([
                            'amount' => $totalpaybleamount * 100,
                            'currency' => 'nzd',
                            'description' => 'Hold the payment',
                            "customer" => $customer->id,
                            'capture' => false,
                        ]);
                        $bookingOrder->charge_id = $charge->id;
                        $bookingOrder->save();
                    }
                }
            }

            // print_r($payable_amount);die;
            //$payable_amount = Cart::getMyCartItemsPayableTotal();

            //Empty Cart
            Cart::emptyMyCart();

            $data = array(
                'orderID' => $bookingOrder->id,
                'ammount' => $bookingOrder->booking_order_items->sum(function ($data) {
                    return $data->totalPrice();
                }),
                'qty' => count($bookingOrder->booking_order_items)
            );
            $event = 'Purchase';
            ConvarsionService::conversionAPI($event, url('/') . '/' . Route::current()->getName(), $data);

            return redirect(route('booking_details', ['id' => $bookingOrder->id]))->with('success', 'Booking success!');
        } catch (Exception $e) {
            Log::error("==========================");
            Log::error($e);
            Log::error("==========================");
            Log::error("StripeController chargeCartBooking Exception: " . $e->getMessage());
            return redirect(route('user_profile'))->with('error', $e->getMessage());
        }
    } //chargeCartBooking()

    public function testPaymentIntentCharge()
    {

        $operators = Cart::getCartOperators();



        foreach ($operators as $operator) {
            if ($operator->stripe_account_id != NULL) {
                $place_products = PlaceProduct::query()->whereIn('id', explode(',', $operator->place_product_ids))->get();
                //$place_products = PlaceProduct::query()->where('id', $operator->place_product_ids)->get();
                foreach ($place_products as $place_product) {
                }
            }
        }

        // dd("d");
        $user = Auth::user();
        $userType = $user->user_type;
        $stripeCustomerId = $user->stripe_customer_id;

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        // Create a PaymentIntent:
        $paymentIntent = \Stripe\PaymentIntent::create([
            'customer' => $stripeCustomerId,
            'amount' => 10000,
            'currency' => 'usd',
            'payment_method_types' => ['card'],
            'transfer_group' => '{ORDER10}',
        ]);

        // dd($paymentIntent);.
    } //testPaymentIntentCharge()


    public function validatePromoCode(Request $request)
    {
        $promoCode = $request->promocode;

        try {
            // Retrieve the coupon from Stripe
            $coupon = \Stripe\Coupon::retrieve($promoCode);

            // Check that the coupon is valid for the product 'Operator Venture'
            if ($coupon->valid === true && $coupon->product === 'Operators Venture') {
                // Return a success response
                return response()->json(['valid' => true]);
            } else {
                // Return an error response
                return response()->json(['valid' => false, 'message' => 'Invalid promo code']);
            }
        } catch (\Exception $e) {
            // Return an error response
            return response()->json(['valid' => false, 'message' => 'Invalid promo code']);
        }
    }

}
