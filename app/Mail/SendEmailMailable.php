<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $mail;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail, $password)
    {
        $this->mail = $mail;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('spa');
    }
}
