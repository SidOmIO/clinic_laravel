<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\AdminLog;

class LogUserLogin
{
    /**
     * Handle the event.
     */
    public function handle(Login $event)
    {
        AdminLog::create([
            'email' => $event->user->email,
            'action_type' => 'login',
        ]);
    }
}
