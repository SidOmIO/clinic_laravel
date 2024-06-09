<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Mail\UniversalMail;

class EmailService
{
    /**
     * Send an email using the UniversalMail mailable.
     *
     * @param string $to
     * @param string $subject
     * @param string $body
     * @param string $view
     * @return void
     */
    public function sendEmail($to, $subjectKey, $bodyKey, $view = 'emails.universal')
    {
        $subject = trans($subjectKey);
        $body = trans($bodyKey);
        Mail::to($to)->send(new UniversalMail($subject, $body, $view));
    }
}