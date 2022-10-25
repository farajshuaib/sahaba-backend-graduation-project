<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class WelcomeMail extends Mailable
{
    public function __construct()
    {
    }

    public function build()
    {
        return $this->view('emails.welcome');
    }
}