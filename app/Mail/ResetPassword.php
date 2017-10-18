<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $pass;
    public $name;

    public function __construct($pass, $name)
    {
        $this->pass = $pass;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_ADDRESS', 'sales@depotile.com'), 'depotile.com')
                    ->subject('Reset Password')
                    ->view('email-depotile.resetPassword');
    }
}
