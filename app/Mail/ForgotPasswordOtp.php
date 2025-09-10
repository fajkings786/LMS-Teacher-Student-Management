<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordOtp extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $email; // Add this property

    public function __construct($otp, $email) // Add email parameter
    {
        $this->otp = $otp;
        $this->email = $email; // Store the email
    }

    public function build()
    {
        return $this->subject('Password Reset OTP')
            ->view('forgotmail')
            ->with([
                'otp' => $this->otp,
                'email' => $this->email // Pass email to the view
            ]);
    }
}