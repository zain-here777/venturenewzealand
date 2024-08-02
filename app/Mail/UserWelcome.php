<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserWelcome extends Mailable
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
        $social_media_link = [
            'facebook_url' => setting('facebook_url'),
            'instagram_url' => setting('instagram_url'),
            'youtube_url' => setting('youtube_url')
        ];
        return $this->view('frontend.mail.user_welcome', ['detail' => $this->detail, 'social_media_link' => $social_media_link]);
    }
}
