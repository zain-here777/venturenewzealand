<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OperatorNewBooking extends Mailable
{
    use Queueable, SerializesModels;

    protected $detail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($detail)
    {
        $this->detail = $detail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $setting = [
            'facebook_url' => setting('facebook_url'),
            'instagram_url' => setting('instagram_url'),
            'youtube_url' => setting('youtube_url'),
            'contactus_phone' => setting('contactus_phone'),
            'contact' => route('page_contact'),
            'contactus_technical_email' => setting('contactus_technical_email'),
            'page_terms_and_conditions' => route('page_terms_and_conditions'),
        ];
        // dd($this->detail);
        return $this->view('frontend.mail.operator_booking_mail', ['detail' => $this->detail, 'setting' => $setting]);
    }
}
