<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;


    private $token;
    private $email;


    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function build()
    {
        return $this->from('support@sahabanft.com', 'SAHABA NFT')
            ->to($this->email)
            ->view('emails.forgot_password', [
                'email' => $this->email,
                'token' => $this->token
            ]);
    }
}
