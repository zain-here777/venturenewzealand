<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\PlaceProduct;
use App\Models\WebNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class productDiscountNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'productDiscountNotification:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::channel('productDiscountNotificationLog')->info("productDiscountNotificationLog handle ---> about to start");

        $daysBefore = 0;
        $discountStart = Carbon::now()->addDays($daysBefore)->format("Y-m-d");

        $place_products = PlaceProduct::query()
        ->where('discount_percentage','!=', NULL)
        ->where('discount_start_date','!=',NULL)
        ->whereDate('discount_start_date',$discountStart)
        ->get();

        Log::channel('productDiscountNotificationLog')->info(count($place_products)." products discount - start");

        foreach ($place_products as $product) {
            $title = 'Discount';
            $body = $product->name." is on $".cleanDecimalZeros($product->discount_percentage)." discount";
            $image = $product->thumb;
            WebNotification::create(
                ['title' => $title,
                'body' => $body,
                'image' => $image,
                'type' => 1, //Broadcast =1
                'delete_type' => 1, //Discount Start =1
                'place_id' => $product->place_id,'product_id' => $product->id]
            );
        }
        
        //--------

        $discountEnd = Carbon::now()->addDays($daysBefore)->format("Y-m-d");

        $place_products = PlaceProduct::query()
        ->where('discount_percentage','!=', NULL)
        ->where('discount_end_date','!=',NULL)
        ->whereDate('discount_end_date',$discountEnd)
        ->get();

        Log::channel('productDiscountNotificationLog')->info(count($place_products)." products discount - end");

        foreach ($place_products as $product) {
            $title = 'Last chance';
            $body = "$".cleanDecimalZeros($product->discount_percentage)." discount on ".$product->name." is about to end";
            $image = $product->thumb;
            WebNotification::create(
                ['title' => $title,
                'body' => $body,
                'image' => $image,
                'type' => 1, //Broadcast =1
                'delete_type' => 2, //Discount Start =1
                'place_id' => $product->place_id,'product_id' => $product->id]
            );
        }


    }//handle()
}
