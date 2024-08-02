<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;

class Rezdy
{
    public static function createBooking($cartItems)
    {
        $arrItems = [];
        $totalPrice = 0;
        foreach ($cartItems as $cart_item) {
            $product_id = $cart_item['place_product_id'];

            if (isRezdyProduct($product_id) == false) {
                continue;
            }

            $product = PlaceProduct::find($product_id);
            $time = $cart_item['booking_date'] . ' ' . $cart_item['booking_time'];
            $quantities = [];

            $price = 0;
            if ($cart_item['number_of_adult'] > 0) {
                $quantities[] = [
                    'optionLabel'   =>  'Adult',
                    'value'         =>  $cart_item['number_of_adult']
                ];

                if (checkIfOnDiscount($product)) {
                    $adult_unit_price = checkIfOnDiscount($product, true);
                } else {
                    $adult_unit_price = cleanDecimalZeros(getRezdyPrice($product));
                }
                $price += $adult_unit_price * $cart_item['number_of_adult'];
            }
            if ($cart_item['number_of_children'] > 0) {
                $quantities[] = [
                    'optionLabel'   =>  'Child',
                    'value'         =>  $cart_item['number_of_children']
                ];
                if (checkIfOnChildDiscount($product)) {
                    $child_unit_price = checkIfOnChildDiscount($product, true);
                } else {
                    $child_unit_price = cleanDecimalZeros(getRezdyPrice($product, $product->child_price, 'child'));
                }
                $price += $child_unit_price * $cart_item['number_of_children'];
            }

            if (count($quantities) > 0) {
                $arrItems[] = [
                    'productCode'       =>  $product->product_code,
                    'startTimeLocal'    =>  $time,
                    'amount'            =>  $price,
                    'quantities'        =>  $quantities
                ];
            }
            $totalPrice += $price;
        }

        $user = auth()->user();
        if (strpos($user->name, " ")) {
            $first_name = substr($user->name, 0 ,strpos($user->name, " "));
            $last_name = substr($user->name, strpos($user->name, " ") + 1, strlen($user->name) - strpos($user->name, " "));
        } else {
            $first_name = $user->name;
            $last_name = "";
        }

        if (count($arrItems)) {
            $arrPaymentsInfo = [
                "customer" => [
                    "firstName" =>  $first_name,
                    "lastName"  =>  $last_name,
                    "email"     =>  $user->email
                ],
                "items" => $arrItems,
                "payments" => [
                    [
                        "amount"    =>  $totalPrice,
                        "type"      =>  "CREDITCARD",
                        "label"     =>  "Paid in CREDITCARD to API"
                    ]
                ]
            ];

            $rezdy_response = app('rezdy')->post('bookings', [
                'json' => $arrPaymentsInfo
            ]);

            $result = json_decode($rezdy_response->getBody(), true);
            Log::info($result);
        }
    }
}
