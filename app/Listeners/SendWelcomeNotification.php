<?php

namespace App\Listeners;

use App\Notifications\Welcome;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendWelcomeNotification
{
    public function __construct()
    {
        //
    }

    public function handle(object $event): void
    {
        $event->user->notify(new Welcome($event->password));
    }
}
