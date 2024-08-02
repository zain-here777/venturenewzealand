<?php

namespace App\Console\Commands;

use App\Models\BookingOrder;
use App\Models\BookingOrderItems;
use Illuminate\Console\Command;

class UpdateBookingStatusCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updatebookingstatus:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update booking status which not approved in 7 days';

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
        \Log::info('==========BookingOrderItems status============');

        $bookings = BookingOrderItems::where('confirm_booking',0)
        ->with('booking_order')
        ->whereHas('booking_order',function($query){
            $query->where('payment_intent_status','pending');
        })
        ->where(function($query){
            $query->whereDate('created_at', '<=', now()->subDays(7))
            ->orWhere('booking_date','<',date('Y-m-d'));
        })
        ->get();
        if(count($bookings) > 0){
            foreach($bookings as $booking){
                $bookingOrder = $booking->booking_orde;
                if($bookingOrder != null){
                    \Log::info($bookingOrder->id);
                    $booking->booking_order->update(['payment_intent_status' => 'canceled']);
                }
            }
        }
    }
}
