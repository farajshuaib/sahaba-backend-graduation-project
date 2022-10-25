<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class NewsMail extends Mailable
{
    public array $details;

    public function __construct($details)
    {
        $this->details = $details;
    }


    public function build()
    {
        return $this->subject($this->details['subject'])
            ->view('emails.news');
    }
}