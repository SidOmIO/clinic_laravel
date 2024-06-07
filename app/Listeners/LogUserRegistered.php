<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use App\Models\AdminLog;

class LogUserRegistered
{
    /**
     * Handle the event.
     */
    public function handle(Registered $event)
    {
        AdminLog::create([
            'email' => $event->user->email,
            'action_type' => 'register',
        ]);
    }
}
