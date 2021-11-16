<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $send_variables;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($send_variables)
    {
        $this->send_variables = $send_variables;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Testing Send Mail')
                ->markdown('Email.testing_mail')->with([
                    'data' => $this->send_variables,
                ]);
    }
}
