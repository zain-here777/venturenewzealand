<?php

namespace App\Jobs;

use App\Mail\OperatorWelcome;
use App\Mail\UserWelcome;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SignUpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->user->user_type == '2') {

            if ($this->user->email) {
                $emailTemplate = new OperatorWelcome([]);
                Mail::to($this->user->email)->send($emailTemplate);
            }

            $email_system = setting('email_system');
            $contactus_email = setting('contactus_email');
            $contactus_technical_email = setting('contactus_technical_email');

            $user = array(
                'name' => $this->user->name,
                'email' => $this->user->email,
                'type' => 'Operator'
            );

            if (isset($email_system)) {
                // Mail::to($appEmailSeting)->send(new NewUserRegistration($user));
                $user['send_mail_to'] = $email_system;
                dispatch(new \App\Jobs\SendEmailToAdminForOperatorSignupJob($user));
            }
            if (isset($contactus_email)) {
                $user['send_mail_to'] = $contactus_email;
                dispatch(new \App\Jobs\SendEmailToAdminForOperatorSignupJob($user));
            }
            if (isset($contactus_technical_email)) {
                $user['send_mail_to'] = $contactus_technical_email;
                dispatch(new \App\Jobs\SendEmailToAdminForOperatorSignupJob($user));
            }
        } else {
            if ($this->user->email) {
                $emailTemplate = new UserWelcome([]);
                Mail::to($this->user->email)->send($emailTemplate);
            }
        }
    }
}
