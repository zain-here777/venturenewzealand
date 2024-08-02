<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    protected $table = 'user_subscriptions';

    protected $fillable = [
        'user_id', 'user_type', 'price', 'days', 'purchase_date', 'charge_id', 'charge_status', 'txn_id', 'txn_status', 'description',
        'subscription_type', 'subscription_id', 'subscription_status', 'price_id', 'product_id',
        'subscription_startdate', 'subscription_enddate', 'is_subscription_canceled'
    ];

    const SUBSCRIPTION_NOT_CANCELED = 0;
    const SUBSCRIPTION_CANCELED = 1;

    public static function getSubscription()
    {
        $user_id = Auth::user()->id;
        return self::where('user_id', $user_id)->orderByDesc('created_at')->first();
    }

    public static function getSubscriptionPlanNameForUserType($user_type)
    {
        if ($user_type == 1) {
            return setting('subscription_plan_name_user');
        } else if ($user_type == 2) {

            $operatorPrice = self::getOperatorStripePriceObject();
            $product = self::getOperatorStripeProductObject($operatorPrice->product);

            return $product->name;

            // return setting('subscription_plan_name_operator');
        } else {
            return "Usertype Invalid";
        }
    }

    public static function getSubscriptionPriceForUserType($user_type)
    {
        if ($user_type == 1) {
            return setting('subscription_price_user');
        } else if ($user_type == 2) {
            $operatorPrice = self::getOperatorStripePriceObject();
            return  $operatorPrice->unit_amount / 100;
            // return setting('subscription_price_operator');
        } else {
            return "Usertype Invalid";
        }
    }

    public static function getSubscriptionDaysForUserType($user_type)
    {
        if ($user_type == 1) {
            return setting('subscription_days_user');
        } else if ($user_type == 2) {
            $operatorPrice = self::getOperatorStripePriceObject();
            $interval = $operatorPrice->recurring->interval;
            $interval_count = $operatorPrice->recurring->interval_count;
            if ($interval_count == 1) {
                $interval_count = "";
            }
            return $interval_count . " " . $interval;

            // return setting('subscription_days_operator');
        } else {
            return "Usertype Invalid";
        }
    }

    public static function getOperatorStripePriceObject()
    {
        // check from settings table on database
        $priceId = setting('subscription_stripe_price_id_operator');
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $price = $stripe->prices->retrieve(
            $priceId,
            []
        );
        if ($price) {
            return $price;
        }
        return false;
    }

    public static function getOperatorStripeProductObject($product_id)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $product = $stripe->products->retrieve(
            $product_id,
            []
        );
        if ($product) {
            return $product;
        }
        return false;
    }

    public static function getUserLastActiveSubscription($user_id)
    {
        return self::query()
            ->where('is_subscription_canceled', self::SUBSCRIPTION_NOT_CANCELED)
            ->where('user_id', $user_id)
            ->where(function ($q) {
                $q->where('subscription_status', 'active')->orWhere('subscription_status', 'trialing');
            })
            ->where('subscription_id', '!=', NULL)
            ->orderBy('id', 'DESC')->first();
    } //getUserLastActiveSubscription()

    public static function getUserLastSubscription()
    {
        $user_id = auth()->user()->id;
        return self::query()
            ->where('user_id', $user_id)
            ->where('subscription_id', '!=', NULL)
            ->orderBy('id', 'DESC')->first();
    } //getUserLastSubscription()

    public static function getStripeAccountId()
    {
        $user_id = auth()->user()->id;
        $row = User::query()
            ->where('id', $user_id)
            ->where('stripe_account_id', '!=', NULL)
            ->orderBy('id', 'DESC')->first();
        if ($row) {
            return $row->stripe_account_id;
        } else {
            return false;
        }
    } //getStripeAccountId()
    public function isEndDate()
    {
        $subscription_enddate =Carbon::parse($this->attributes['subscription_enddate']);
        if ($subscription_enddate->gt(Carbon::now())) {
            return false;
        }
        return true;
    }
}
