<?php

namespace App\Http\Controllers\Frontend;


use App\Commons\Response;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Place;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function booking(Request $request)
    {
        $request['user_id'] = Auth::id();

        if ($request->date) {
            $request['date'] = Carbon::parse($request->date);
        }

        if ($request->time) {
            $request['time'] = date('H:i:s', strtotime(Carbon::parse($request->time)));
        }

        $data = $this->validate($request, [
            'user_id' => '',
            'place_id' => '',
            'numbber_of_adult' => '',
            'numbber_of_children' => '',
            'date' => '',
            'time' => '',
            'name' => '',
            'email' => '',
            'phone_number' => '',
            'message' => '',
            'type' => ''
        ]);

        $booking = new Booking();
        $booking->fill($data);

        if ($booking->save()) {
            $place = Place::find($request['place_id']);

            $to_emails = [];
            if($place->email){
                $to_emails[] = $place->email;
            }
            $to_emails[] = setting('email_system');
            $res = "You successfully created your booking!";
            $message_title = "You have a booking from";
            if ($request->type == Booking::TYPE_CONTACT_FORM) {
                $res = "Your message has been sent!";
                Log::debug("Booking::TYPE_CONTACT_FORM: " . $request->type);
                $name = $request->name;
                $email = $request->email;
                $phone = $request->phone_number;
                $datetime = "";
                $numberofadult = "";
                $numberofchildren = "";
                $text_message = $request->message;
                $message_title = "You have a message from";
            } else {
                $res = "You have successfully submitted your reservation!";
                Log::debug("Booking::submit: " . $request->type);
                $name = user()->name;
                $email = user()->email;
                $phone = user()->phone_number;
                $datetime = Carbon::parse($booking->date)->format('Y-m-d') . " " . $booking->time;
                $numberofadult = $booking->numbber_of_adult;
                $numberofchildren = $booking->numbber_of_children;
                $text_message = "";
                $message_title = "You have a reservation from";
            }

            foreach ($to_emails as $recipient) {

                Mail::send('frontend.mail.new_booking', [
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'place' => $place->name,
                    'datetime' => $datetime,
                    'numberofadult' => $numberofadult,
                    'numberofchildren' => $numberofchildren,
                    'text_message' => $text_message,
                    'booking_at' => $booking->created_at,
                    'message_title' => $message_title
                ], function ($message) use ($request,$recipient,$name) {
                    $message->to($recipient, "{$name}")->subject('Booking from ' . $request->first_name);
                });

            }//foreach

            /* reservation mail send operator to user */
            if($request->type == 1){
                $to_user_email = user()->email;
                $to_user_name = user()->name;
                $getOperatorData = Place::with('categories')->where('places.id', '=', $request['place_id'])->join('users', 'users.id', '=', 'places.user_id')->first();
                $place = Place::find($request['place_id']);
                $mailDataForUser = [
                    'name' => $getOperatorData->name,
                    'address' => $getOperatorData->address,
                    'phone' => $getOperatorData->phone_number,
                    'email' => $getOperatorData->email,
                    'place' => $place->name,
                    'datetime' => Carbon::parse($booking->date)->format('Y-m-d') . " " . $booking->time
                ];

                Mail::send('frontend.mail.new_booking_user', $mailDataForUser, function ($message) use ($request,$to_user_email,$to_user_name) {
                    $message->to($to_user_email, "{$to_user_name}")->subject('Booking from ');
                });
            }
            /* //reservation mail send operator to user */

        }

        return $this->response->formatResponse(200, $booking, $res);
    }
}
