<?php

namespace App\Listeners;

use App\Notifications\PasswordUpdated;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPasswordUpdatedNotification
{
    public function __construct()
    {
        //
    }

    public function handle(PasswordReset $event): void
    {
        $event->user->notify(new PasswordUpdated());
    }
}
