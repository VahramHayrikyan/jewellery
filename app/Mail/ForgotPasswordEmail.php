<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    private string $randomPassword;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $randomPassword)
    {
        $this->randomPassword = $randomPassword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): ForgotPasswordEmail
    {
        return $this->view('mails.forgot-password', ['randomPassword' => $this->randomPassword]);
    }
}
