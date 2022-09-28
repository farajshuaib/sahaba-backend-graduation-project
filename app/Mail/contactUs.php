<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class contactUs extends Mailable
{
    use Queueable, SerializesModels;


    public array $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->subject($this->details['subject'])
            ->from($this->details['email'])
            ->to('info@sahabanft.com')
            ->view('emails.contact_email');
    }
}
