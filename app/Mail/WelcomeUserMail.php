<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class WelcomeUserMail extends Mailable
{
    public $userData;

    public function __construct($userData)
    {
        $this->userData = $userData;
    }

    public function build()
    {
        return $this->subject('Our Portal - Verify Your Email Address')
            ->view('emails.welcome_user');
    }
}
