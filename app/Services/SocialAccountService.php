<?php

namespace App\Services;

use App\Http\Controllers\StripeController;
use App\Models\User;
use Laravel\Socialite\Contracts\User as ProviderUser;
use App\Models\SocialAccount;

class SocialAccountService
{
    public static function createOrGetUser(ProviderUser $providerUser, $social)
    {
        $account = SocialAccount::whereProvider($social)
            ->whereProviderUserId($providerUser->getId())
            ->first();
        // dd($account->user);
        if ($account) {
            StripeController::createCustomerIfNotExists($account->user->id);
            return $account->user;
        } else {
            $email = $providerUser->getEmail() ?? $providerUser->getNickname();
            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $social
            ]);
            $user = User::whereEmail($email)->first();

            if (session('user_type') == '' && empty(session('user_type'))) {
                session(['user_type' => 1]);
            }

            if (!$user) {
                $user = new User();
                $user->create((object)[
                    'email' => $email,
                    'name' => $providerUser->getName(),
                    'password' => $providerUser->getName(),
                    'user_type' => session('user_type')
                ]);
                $user->save();
            }

            $account->user()->associate($user);
            $account->save();
            StripeController::createCustomerIfNotExists($user->id);
            return $user;
        }
    }
}
