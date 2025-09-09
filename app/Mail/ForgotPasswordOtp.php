<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordOtp extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function build()
    {
        return $this->subject('Password Reset OTP')
            ->view('forgotmail') // Blade email view
            ->with(['otp' => $this->otp]); // 👈 OTP yahan pass karna zaruri
    }
}
