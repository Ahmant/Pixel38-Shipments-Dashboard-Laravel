<?php

namespace App\Mail\Auth;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $code, $lifetime)
    {
        $this->user = $user;
        $this->code = $code;
        $this->lifetime = $lifetime;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Email Verification')
                    ->markdown('partials.mail.emailVerification')
                    ->with([
                        'code' => $this->code,
                        'lifetime' => $this->lifetime
                    ]);
    }
}
