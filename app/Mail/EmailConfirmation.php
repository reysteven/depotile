<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $emailHash;
    public $name;

    public function __construct($emailHash, $name)
    {
        $this->emailHash = $emailHash;
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
                    ->subject('Email Confirmation')
                    ->view('email-depotile.emailConfirmation');
    }
}
