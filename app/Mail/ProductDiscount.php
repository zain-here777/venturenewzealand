<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductDiscount extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->data['email_type']=="product_discount_start"){
            return $this->view('frontend.mail.product_discount_start',$this->data);    
        }

        if($this->data['email_type']=="product_discount_end"){
            return $this->view('frontend.mail.product_discount_end',$this->data);    
        }
    }
}
