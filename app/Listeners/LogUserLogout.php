<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Models\AdminLog;

class LogUserLogout
{
    /**
     * Handle the event.
     */
    public function handle(Logout $event)
    {
        AdminLog::create([
            'email' => $event->user->email,
            'action_type' => 'logout',
        ]);
    }
}
