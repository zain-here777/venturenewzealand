<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $freeSubscriptionEndDate = Carbon::createFromFormat('Y-m-d H:i:s', setting('operator_trial_date') . " 00:00:00");
        if ($freeSubscriptionEndDate->gt(Carbon::now())) {
            $users = User::where('user_type', User::USER_TYPE_OPERATOR)
                ->where(function ($q) use ($freeSubscriptionEndDate) {
                    $q->where(function ($q)  use ($freeSubscriptionEndDate) {
                        $q->WhereNull('subscription_valid_till')
                            ->orWhere('subscription_valid_till', '<', $freeSubscriptionEndDate);
                    });
                    // ->orWhere(function ($q)  use ($freeSubscriptionEndDate) {
                    // $q->orDoesntHave('userSubscriptions', function ($q) use ($freeSubscriptionEndDate) {
                    //     $q->whereDate('subscription_enddate', '>=', $freeSubscriptionEndDate);
                    // });
                    // ->orDoesntHave('userSubscriptions');
                    // });
                })
                ->get();
            foreach ($users as $user) {
                $user->subscription_valid_till = Carbon::parse(setting('operator_trial_date'))->format('Y-m-d H:i:s');
                $user->save();
            }
        }
        $users = User::all();
        $stripe = new \Stripe\StripeClient(
            config('services.stripe.secret')
        );
        foreach ($users as $user) {
            try {
                if (isset($user->stripe_customer_id)) {
                    $stripe->customers->retrieve(
                        $user->stripe_customer_id,
                        []
                    );
                }
            } catch (Exception $e) {
                Log::error($user);
                Log::error($e);
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
                $user->stripe_account_id = null;
                $user->stripe_account_id = null;
                $user->stripe_access_token = null;
                $user->stripe_refresh_token = null;
                $user->stripe_token_type = null;
                $user->save();
            }
        }


        // $this->call(UsersTableSeeder::class);
    }
}
