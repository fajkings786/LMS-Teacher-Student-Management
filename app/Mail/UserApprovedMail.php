<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class UserApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $role;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->role = $user->role;
    }

    public function build()
    {
        return $this->subject(' Account Approved - Welcome!')
                    ->view('emails.user-approved');
    }
}
