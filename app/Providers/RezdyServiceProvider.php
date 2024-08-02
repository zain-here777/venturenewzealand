<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RezdyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('rezdy', function ($app) {
            $apiKey = env('REZDY_API_KEY');
            $baseUri = 'https://api.rezdy.com/v1/';

            return new \GuzzleHttp\Client([
                'base_uri' => $baseUri,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Api-Key' => $apiKey,
                ],
                'query' => [
                    'apiKey' => $apiKey,
                ],
            ]);
        });
    }
}
