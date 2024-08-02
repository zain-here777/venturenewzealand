<?php

namespace App\Observers;

use App\Models\PlaceProduct;
use App\Models\WebNotification;
use Illuminate\Support\Facades\Log;

class PlaceProductObserver
{
    /**
     * Handle the place product "created" event.
     *
     * @param  \App\PlaceProduct  $placeProduct
     * @return void
     */
    public function created(PlaceProduct $placeProduct)
    {
        $place = $placeProduct->place()->first();
        $placeName = $place->name;
        $productName = $placeProduct->name;

        $title = 'New product';
        $body = 'New product '.$productName.' added in '.$placeName;
        $image = $placeProduct->thumb;
        WebNotification::create(
            ['title' => $title,
            'body' => $body,
            'image' => $image,
            'type' => 1, //Broadcast =1
            'delete_type' => 3, //Product Added = 3
            'place_id' => $place->id,'product_id' => $placeProduct->id]
        );
    }

    /**
     * Handle the place product "updated" event.
     *
     * @param  \App\PlaceProduct  $placeProduct
     * @return void
     */
    public function updated(PlaceProduct $placeProduct)
    {
        // Log::info("Products updated".$placeProduct);
        // $place = $placeProduct->place()->first();
        // $placeName = $place->name;
        // $productName = $placeProduct->name;

        // $title = 'Product updated';
        // $body = 'Product '.$productName.' updated in '.$placeName;
        // $image = $placeProduct->thumb;
        // WebNotification::create(
        //     ['title' => $title,
        //     'body' => $body,
        //     'image' => $image,
        //     'type' => 1, //Broadcast =1
        //     'delete_type' => 4, //Product updated = 4
        //     'place_id' => $place->id,'product_id' => $placeProduct->id]
        // );
    }

    /**
     * Handle the place product "deleted" event.
     *
     * @param  \App\PlaceProduct  $placeProduct
     * @return void
     */
    public function deleted(PlaceProduct $placeProduct)
    {
        Log::info("Products deleted".$placeProduct);
    }

    /**
     * Handle the place product "restored" event.
     *
     * @param  \App\PlaceProduct  $placeProduct
     * @return void
     */
    public function restored(PlaceProduct $placeProduct)
    {
        Log::info("Products restored".$placeProduct);
    }

    /**
     * Handle the place product "force deleted" event.
     *
     * @param  \App\PlaceProduct  $placeProduct
     * @return void
     */
    public function forceDeleted(PlaceProduct $placeProduct)
    {
        Log::info("Products forceDeleted".$placeProduct);
    }
}
