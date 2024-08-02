<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $url;
    protected $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $url)
    {
        $this->url = $url;
        $this->name = $name;
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
        // dd($setting);
        return $this->from(setting('mail_from_address'), setting('mail_from_name'))->view(
            'frontend.mail.user_reset_password',
            [
                'url' => $this->url,
                'name' => $this->name,
                'setting' => $setting
            ]
        );
    }
}
