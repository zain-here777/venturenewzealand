<?php

namespace App\Services;


use App\Models\User;

use Exception;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;
use FacebookAds\Object\ServerSide\ActionSource;
use FacebookAds\Object\ServerSide\Content;
use FacebookAds\Object\ServerSide\CustomData;
use FacebookAds\Object\ServerSide\DeliveryCategory;
use FacebookAds\Object\ServerSide\Event;
use FacebookAds\Object\ServerSide\EventRequest;
use FacebookAds\Object\ServerSide\UserData;
use Auth;

class ConvarsionService
{
    public static function conversionAPI($trace, $source_url, $data = '')
    {
        try {
            if(config('app.env') === 'stage'){
                return true;
            }

            $trace = $trace;
            $source_url = $source_url;

            ///// get Access token for convsion API
            $access_token = config('services.facebook_conversion_api.ConversionAPIToken');
            $pixel_id = config('services.facebook_conversion_api.ConversionPixelId');

            ///// Call API
            $api = Api::init(null, null, $access_token);
            $api->setLogger(new CurlLogger());

            ///// Set user data for sending conversion API
            $user_data = (new UserData())
                ->setEmails(array(Auth::user()->email))
                ->setClientIpAddress($_SERVER['REMOTE_ADDR'])
                ->setClientUserAgent($_SERVER['HTTP_USER_AGENT'])
                ->setFbc('fb.1.1554763741205.AbCdEfGhIjKlMnOpQrStUvWxYz1234567890')
                ->setFbp('fb.1.1558571054389.1098115397');


            ////// customer Parameter array when calling purschase API.
            ////// This only when calling purschase API.
            if ($trace == 'Purchase') {
                if (isset($data)) {
                    $content = (new Content())
                        ->setProductId($data['orderID'])
                        ->setQuantity($data['qty'])
                        ->setDeliveryCategory(DeliveryCategory::HOME_DELIVERY);

                    $custom_data = (new CustomData())
                        ->setContents(array($content))
                        ->setCurrency('nzd')
                        ->setValue($data['ammount']);
                }
            }

            ////// event Parameter array.
            $event = (new Event())
                ->setEventName($trace)
                ->setEventTime(time())
                ->setEventSourceUrl($source_url)
                ->setUserData($user_data)
                ->setActionSource(ActionSource::WEBSITE);
            if ($trace == 'Purchase') {
                $event = $event->setCustomData($custom_data);
            }
            $events = array();
            array_push($events, $event);

            ////// send request for convserion API
            $request = (new EventRequest($pixel_id))->setEvents($events);
            try {
                $response = $request->execute();
            } catch (Exception $e) {
            }
            //code...
        } catch (\Throwable $th) {
           info($th);
           return false;
        }
    }
}
