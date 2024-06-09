<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UniversalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $body;
    public $view;

    /**
     * Create a new message instance.
     *
     * @param string $subject
     * @param string $body
     * @param string $view
     */
    public function __construct($subject, $body, $view)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->view = $view;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(trans($this->subject))
                    ->markdown('emails.universal')
                    ->with([
                        'body' => trans($this->body),
                    ]);
    }
}
