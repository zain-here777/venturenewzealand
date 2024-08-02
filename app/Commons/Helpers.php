<?php

use Illuminate\Support\Facades\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
/*
 * Const general
 */

const PRICE_RANGE = [
    "" => "None",
    "0" => "Free",
    "1" => "$",
    "2" => "$$",
    "3" => "$$$",
    "4" => "$$$$",
];

const DAYS = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

const SOCIAL_LIST = [
    'Facebook' => [
        'icon' => 'la la-facebook-f',
        'name' => 'Facebook',
        'base_url' => 'https://www.facebook.com/',
    ],
    'Instagram' => [
        'icon' => 'la la-instagram',
        'name' => 'Instagram',
        'base_url' => 'https://www.instagram.com/'
    ],
    'Twitter' => [
        'icon' => 'la la-twitter',
        'name' => 'Twitter',
        'base_url' => 'https://twitter.com/'
    ],
    'Youtube' => [
        'icon' => 'la la-youtube',
        'name' => 'Youtube',
        'base_url' => 'https://www.youtube.com/'
    ],
    'Pinterest' => [
        'icon' => 'la la-pinterest',
        'name' => 'Pinterest',
        'base_url' => 'https://www.pinterest.com/'
    ],
    'Snapchat' => [
        'icon' => 'la la-snapchat',
        'name' => 'Snapchat',
        'base_url' => 'https://www.snapchat.com/'
    ]
];

// const SOCIAL_LIST = [
//     'Facebook' => [
//         'icon' => 'fa fa-facebook-f',
//         'name' => 'facebook',
//         'base_url' => 'https://www.facebook.com/',
//         // 'base_url' => ''
//     ],
//     'Instagram' => [
//         'icon' => 'la la-instagram',
//         'name' => 'instagram',
//         'base_url' => 'https://www.instagram.com/'
//     ],
//     'Twitter' => [
//         'icon' => 'la la-twitter',
//         'name' => 'twitter',
//         'base_url' => 'https://twitter.com/'
//     ],
//     'Youtube' => [
//         'icon' => 'la la-youtube',
//         'name' => 'youtube',
//         'base_url' => 'https://www.youtube.com/'
//     ],
//     'Pinterest' => [
//         'icon' => 'la la-pinterest',
//         'name' => 'pinterest',
//         'base_url' => 'https://www.pinterest.com/'
//     ],
//     'Snapchat' => [
//         'icon' => 'la la-snapchat',
//         'name' => 'snapchat',
//         'base_url' => 'https://www.snapchat.com/'
//     ]
// ];

const STATUS = [
    0 => "Deactive",
    1 => "Active",
    2 => "Pending",
    4 => "Deleted",
];

function isRoute($name = '')
{
    if (!$name || (is_array($name) && !count($name)) || !Request::route()) {
        return false;
    }
    if (is_array($name)) {
        return in_array(Request::route()->getName(), $name);
    }
    return Request::route()->getName() === $name;
}

/**
 * function helper
 * @return \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable
 */
function user()
{
    return \Illuminate\Support\Facades\Auth::user();
}

function isActiveMenu($router_name)
{
    if (isRoute($router_name)) {
        return "active";
    }
    return "";
}

function isChecked($val1, $val2)
{
    if (is_array($val2)) {
        if (in_array($val1, $val2)) {
            return "checked";
        } else {
            return "";
        }
    } else {
        if ($val1 == $val2) {
            return "checked";
        } else {
            return "";
        }
    }
}

function isSelected($val1, $val2)
{
    if (is_array($val2)) {
        if (in_array($val1, $val2)) {
            return "selected";
        } else {
            return "";
        }
    } else {
        if ($val1 == $val2) {
            return "selected";
        } else {
            return "";
        }
    }
}

function isActive($val1, $val2)
{
    if (is_array($val2)) {
        if (in_array($val1, $val2)) {
            return "active";
        } else {
            return "";
        }
    } else {
        if ($val1 === $val2) {
            return "active";
        } else {
            return "";
        }
    }
}


function isDisabled($val1, $val2)
{
    if ($val1 === $val2) {
        return "disabled";
    } else {
        return "";
    }
}

function isMobile()
{
    $useragent = $_SERVER['HTTP_USER_AGENT'];

    if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
        return true;
    }
    return false;
}

function generateRandomString($length = 5)
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getImageUrl($image_file)
{
    if ($image_file) {
        return asset("uploads/{$image_file}");
    }
    return "https://via.placeholder.com/300x300?text=VentureNZ";
}

function getCitymapUrl($image_file)
{
    if ($image_file) {
        return asset("uploads/city/map/{$image_file}");
    }
    return "https://via.placeholder.com/300x300?text=VentureNZ";
}

function getCategoryMakerUrl($image_file)
{
    if ($image_file) {
        return asset("uploads/categorymarker/{$image_file}");
    }
    return "https://via.placeholder.com/300x300?text=VentureNZ";
}

function getProductImageUrl($image_path_or_url)
{
    if ($image_path_or_url) {
        return $image_path_or_url;
    }
    return "https://via.placeholder.com/300x300?text=VentureNZ";
}

function getQRCodeImageUrl($image_file)
{
    if ($image_file) {
        return asset("uploads/qrcodes/{$image_file}.png");
    }
    return "https://via.placeholder.com/300x300?text=VentureNZ";
}

function getCategoryMapMarkerImageUrl($image_file)
{
    if ($image_file) {
        return asset("uploads/categorymarker/{$image_file}.png");
    }
    return "https://via.placeholder.com/300x300?text=VentureNZ";
}

function getCategoryIcon($small_icon, $image_file = false)
{
    if ($small_icon) {
        return asset("uploads/categorymarker/{$small_icon}");
    } else if ($image_file) {
        return asset("uploads/categorymarker/{$image_file}");
    } else {
        return "https://via.placeholder.com/300x300?text=VentureNZ";
    }
}

function getUserAvatar($image_file)
{
    if ($image_file) {
        return "/uploads/{$image_file}";
    }
    return "/assets/images/default_avatar.svg";
}

function getUserDrvLicThumb($image_file)
{
    if ($image_file) {
        return "/uploads/{$image_file}";
    } else {
        return "/assets/images/default_driverlicense.png";
    }
}

function getUserPassportThumb($image_file)
{
    if ($image_file) {
        return "/uploads/{$image_file}";
    } else {
        return "/assets/images/default_passport.png";
    }
}




function formatDate($date, $format)
{
    return Carbon::parse($date)->format($format);
}

if (!function_exists('setting')) {

    function setting($key, $default = null)
    {
        if (is_null($key)) {
            return new \App\Models\Setting();
        }

        if (is_array($key)) {
            return \App\Models\Setting::set($key[0], $key[1]);
        }

        if ($key == "template") {
            $value = "01";
        } else {
            $value = \App\Models\Setting::get($key);
        }

        return is_null($value) ? value($default) : $value;
    }
}

function getSlug($request, $key)
{
    $language_default = \App\Models\Language::query()
        ->where('is_default', \App\Models\Language::IS_DEFAULT)
        ->select('code')
        ->first();
    $language_code = $language_default->code;
    $value = $request[$language_code][$key];
    $slug = \Illuminate\Support\Str::slug($value);
    return $slug;
}

function SEOMeta($title = '', $description = '', $image = null, $canonical = '', $type = 'website')
{
    $image = $image ? $image : asset('public/uploads/618a37e95b657_1636448233.png');

    SEO::setTitle($title);
    SEO::setDescription($description);
    SEO::opengraph()->setUrl(url()->current());
    SEO::setCanonical(url()->current());
    SEO::opengraph()->addProperty('type', $type);
    SEO::opengraph()->addProperty("image", $image);
    SEO::opengraph()->addProperty("site_name", setting('app_name'));
}

function flagImageUrl($language_code)
{
    return asset("assets/images/flags/{$language_code}.png");
}

function getYoutubeId($url)
{
    //$url = "http://www.youtube.com/watch?v=C4kxS1ksqtw&feature=relate";
    parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_vars);
    return $my_array_of_vars ? $my_array_of_vars['v'] : '';
}

function randomColorClassForSlider()
{
    $colorOptions = array(
        "dark-sky-blue",
        "rosy-pink",
        "dodger-blue",
        "yellow",
        "green"
    );

    $optionsLength = count($colorOptions);
    $randomIndex = rand(0, ($optionsLength - 1));

    return $colorOptions[$randomIndex];
} //randomColorClassForSlider()

function isOperatorUser()
{
    return auth()->user() && auth()->user()->isOperator();
}

function isUserUser()
{
    return auth()->user() && auth()->user()->isUser();
}

function isUserAdmin()
{
    return auth()->user() && auth()->user()->isAdmin();
}

function isUserHaveMembership()
{
    if (auth()->user() && auth()->user()->subscription_valid_till) {
        $validTill = auth()->user()->subscription_valid_till;
        if (Carbon::parse($validTill)->format('Y-m-d') >= Carbon::now()->format('Y-m-d')) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function getUserTypePhrase($userType)
{
    $userTypes = array("User", "Operator");
    return $userTypes[$userType - 1];
}

function getWebNotifications()
{
    if (isUserHaveMembership()) {
        $user_id = auth()->user()->id;

        //Places wishlist
        $userWishlists = \App\Models\Wishlist::where('user_id', $user_id)->get()->toArray();
        $places_ids = array_column($userWishlists, 'place_id');

        //Products wishlist
        $userProductWishlists = \App\Models\PlaceProductWishlist::where('user_id', $user_id)->get()->toArray();
        $product_ids = array_column($userProductWishlists, 'product_id');

        //Places Interest
        $userInterests = \App\Models\UserInterest::where('user_id', $user_id)->get()->toArray();
        $userInterestsArr = array_column($userInterests, 'interest_id');
        $place_interest_ids = \App\Models\PlaceInterest::whereIn('interest_id', $userInterestsArr)->get()->toArray();
        $place_interest_id_arr = array_column($place_interest_ids, 'place_id');

        //Get actual notification from web_notifications table
        $webNotifications = \App\Models\WebNotification::with('place')
            ->where(function ($q) use ($places_ids, $product_ids, $place_interest_id_arr) {
                $q->whereIn('place_id', $places_ids)
                    ->OrWhereIn('product_id', $product_ids)
                    ->OrWhereIn('place_id', $place_interest_id_arr);
            })
            ->orWhere(function ($q) use ($user_id) {
                $q->where('type', \App\Models\WebNotification::TYPE_SINGLE)->where('for_user_id', $user_id);
            })
            ->orderBy('id', 'DESC')->get();
        foreach ($webNotifications as $note) {
            if (in_array($note->place_id, $place_interest_id_arr)) {
                $note->title = 'Something you may be interested in has updated their pricing, check it out!';
            }
            if (in_array($note->product_id, $product_ids)) {
                $note->title = 'Something in your wishlist has had a price update, check it out!';
            }
            if (in_array($note->place_id, $places_ids)) {
                $note->title = 'One of your favorites has updated their pricing, check it out!';
            }
        }

        //Unread notification count
        $notificationCount = $webNotifications->count();
        $readCount = \App\Models\WebNotificationAction::where('user_id', $user_id)->where(function ($q) {
            $q->where('read_at', '!=', NULL)->orWhere('delete_at', '!=', NULL);
        })->count();
        $unReadCount = ($notificationCount - $readCount);
        if ($unReadCount < 0) {
            $unReadCount = 0;
        }
        // $unReadCount = abs($unReadCount);

        return ['notifications' => $webNotifications, 'unread_count' => $unReadCount, 'message' => 'No Notifications', 'reason' => ''];
    }
    return ['notifications' => [], 'unread_count' => 0, 'message' => 'No Notification', 'reason' => 'Membership required'];
}

function dateFormat($date, $format = false)
{
    if ($format == false) {
        return Carbon::parse($date)->format("d-m-Y");
    } else {
        return Carbon::parse($date)->format($format);
    }
}

function dateTimeFormat($dateTime, $format = false)
{
    if ($format == false) {
        return Carbon::parse($dateTime)->format("d-m-Y h:i:s A");
    } else {
        return Carbon::parse($dateTime)->format($format);
    }
}

function isNumberEven($number)
{
    if ($number % 2 == 0)
        return true;
    else
        return false;
}

function cleanDecimalZeros($decimalNumber)
{
    return floatval($decimalNumber) + 0;
}

function participantWinnerStatus()
{
    return App\Models\CompetitionParticipation::STATUS_WIN;
}

function hex2rgba($color, $opacity = false)
{

    $default = 'rgb(0,0,0)';

    //Return default if no color provided
    if (empty($color))
        return $default;

    //Sanitize $color if "#" is provided
    if ($color[0] == '#') {
        $color = substr($color, 1);
    }

    //Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
        $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
    } elseif (strlen($color) == 3) {
        $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
    } else {
        return $default;
    }

    //Convert hexadec to rgb
    $rgb =  array_map('hexdec', $hex);

    //Check if opacity is set(rgba or rgb)
    if ($opacity) {
        if (abs($opacity) > 1)
            $opacity = 1.0;
        $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
    } else {
        $output = 'rgb(' . implode(",", $rgb) . ')';
    }

    //Return rgb(a) color string
    return $output;
}

function isRezdyProduct($product_id)
{
    $product = \App\Models\PlaceProduct::find($product_id);

    if ($product->product_code) {
        $product_response = app('rezdy')->get('products/' . $product->product_code, [
            'query' => [
                'apiKey' => '90ee8baf2ee0439aaf476fa2a9b6b68f'
            ]
        ]);
        $rezdy_product = json_decode($product_response->getBody(), true);

        if ($rezdy_product && isset($rezdy_product['product'])) {
            return true;
        }
    }

    return false;
}

function getRezdyPrice($product, $default_price = null, $price_label = 'adult')
{

    // Check if the price data is cached
    $cacheKey = 'rezdy_price_' . $product->id;
    if (Cache::has($cacheKey)) {
        return Cache::get($cacheKey);
    }

    $isRezdy = false;
    $rezdyPrice = 0;

    if ($product->product_code) {
        
        try {

            $start_time = microtime(true);
            $product_response = app('rezdy')->get('products/' . $product->product_code, [
                'query' => [
                    'apiKey' => '90ee8baf2ee0439aaf476fa2a9b6b68f'
                ]
            ]);
            $rezdy_product = json_decode($product_response->getBody(), true);

            if ($rezdy_product && isset($rezdy_product['product'])) {
                if (isset($rezdy_product['product']['priceOptions'])) {
                    $arrPriceOptions = $rezdy_product['product']['priceOptions'];

                    if (count($arrPriceOptions) === 1) {
                        $rezdyPrice = $arrPriceOptions[0]['price'];
                        $isRezdy = true;
                    } else {
                       
                        foreach ($arrPriceOptions as $price_options) {
                            $label = strtolower($price_options['label']);
                            if (strpos($label, $price_label) !== false) {
                                $rezdyPrice = $price_options['price'];
                                $isRezdy = true;
                                break;
                            }
                        }
                    }
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    if ($isRezdy) {
        $price = $rezdyPrice;
    } else {
        if ($default_price) {
            return $default_price;
        } else {
            $price = $product->price;
        }
    }

    Cache::put($cacheKey, $price, now()->addHours(10)); // Cache for 1 hour, adjust as needed

    return $price;
}

function getRezdyBookingAvailability($product_id, $date)
{
    $product = \App\Models\PlaceProduct::find($product_id);

    try {
        if ($product && $product->product_code) {
            $firstTime = date('Y-m-d 0:0:0', strtotime($date));
            $endTime = date('Y-m-d 23:59:59', strtotime($date));

            $product_response = app('rezdy')->get('availability', [
                'query' => [
                    'apiKey'            =>  env('REZDY_API_KEY'),
                    'productCode'       =>  $product->product_code,
                    'startTimeLocal'    =>  $firstTime,
                    'endTimeLocal'      =>  $endTime,
                    'limit'             =>  '200'
                ]
            ]);
            $product_availity = json_decode($product_response->getBody(), true);

            if ($product_availity) {
                $arrBookingAvailibility = [];
                $arrBookingSeats = [];

                if (count($product_availity["sessions"]) > 0) {
                    foreach ($product_availity["sessions"] as $rezdy_pro) {
                        $slot = date('h:i A', strtotime($rezdy_pro["startTimeLocal"]));
                        $arrBookingAvailibility[] = $slot;
                        $arrBookingSeats[$slot] = $rezdy_pro["seatsAvailable"];
                    }
                }

                return [
                    'slot_availibility' => $arrBookingAvailibility,
                    'slot_seats'        => $arrBookingSeats
                ];
            }
        } else {
            return false;
        }
    } catch (\Throwable $th) {
    }

    return false;
}

function checkIfOnDiscount($product, $withDiscountedPrice = false)
{
    try {
        $today = Carbon::now()->format("Y-m-d");
        $discountStartDate = date('Y-m-d', strtotime($product->discount_start_date));
        $discountEndDate = date('Y-m-d', strtotime($product->discount_end_date));

        if ($product->discount_start_date && $product->discount_end_date) {
            if ($discountStartDate <= $today && $discountEndDate >= $today) {
                if ($withDiscountedPrice) {
                    // $price = $product->price;
                    $price = getRezdyPrice($product);
                    $per = $product->discount_percentage;
                    if ($per) {
                        // return cleanDecimalZeros(number_format($price - (($price*$per)/100),2));
                        return cleanDecimalZeros(number_format($price - $per, 2, '.', ''));
                    } else {
                        return cleanDecimalZeros(number_format($price, 2, '.', ''));
                        //return false;
                    }
                } else {
                    return true;
                }
            }
        }
        return false;
    } catch (\Exception $e) {
        return false;
    }
}

function checkIfOnCarDiscount($product, $withDiscountedPrice = false)
{
    try {
        $today = Carbon::now()->format("Y-m-d");
        $discountStartDate = date('Y-m-d', strtotime($product->discount_start_date));
        $discountEndDate = date('Y-m-d', strtotime($product->discount_end_date));

        $place = $product->place;
        if ($place->categories[0]->slug == 'travel' && $place->slug == 'sealink') {
            if ($product->discount_start_date && $product->discount_end_date) {
                if ($discountStartDate <= $today && $discountEndDate >= $today) {
                    if ($withDiscountedPrice) {
                        $price = getRezdyPrice($product, $product->car_price);
                        $per = $product->car_discount_price;
                        if ($per) {
                            // return cleanDecimalZeros(number_format($price - (($price*$per)/100),2));
                            return cleanDecimalZeros(number_format($price - $per, 2, '.', ''));
                        } else {
                            return cleanDecimalZeros(number_format($price, 2, '.', ''));
                            //return false;
                        }
                    } else {
                        return true;
                    }
                }
            }
            return false;
        }
    } catch (\Exception $e) {
        return false;
    }
}

function checkIfOnChildDiscount($product, $withDiscountedPrice = false)
{
    $today = Carbon::now()->format("Y-m-d");
    if (isset($product->discount_start_date) && isset($product->discount_end_date)) {
        $discountStartDate = date('Y-m-d', strtotime($product->discount_start_date));
        $discountEndDate = date('Y-m-d', strtotime($product->discount_end_date));
        if ($discountStartDate <= $today && $discountEndDate >= $today) {
            if ($withDiscountedPrice) {
                $price = getRezdyPrice($product, $product->child_price, 'child');
                $per = $product->child_discount_price;

                if ($per) {
                    return cleanDecimalZeros(number_format($price - $per, 2, '.', ''));
                } else {
                    return cleanDecimalZeros(number_format($price, 2, '.', ''));
                    //return false;
                }
            } else {
                return true;
            }
        }
    }
    return false;
}

function checkPlaceCreateLimit()
{
    if (auth()->user()) {

        $count = App\Models\Place::getPlacesCount();
        $placeCreateLimit = setting('place_limit_for_operator');

        if ($count < $placeCreateLimit) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}//checkPlaceCreateLimit()
