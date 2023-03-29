<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;
    public $data = [];


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $userv)

    {
        // $this->mailData = $mailData;
        $this->data = $userv;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('aya@gmail.com')
            ->subject("email de validation")
            ->view('emails.test');
    }
}
