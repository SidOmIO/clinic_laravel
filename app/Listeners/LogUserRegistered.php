<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use App\Models\AdminLog;
use App\Services\EmailService;

class LogUserRegistered
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event)
    {

        $email = $event->user->email;
        $this->emailService->sendEmail($email, 'email.register_title', 'email.register_body');
        AdminLog::create([
            'email' => $email,
            'action_type' => 'register',
        ]);
    }
}
