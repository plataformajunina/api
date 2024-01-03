<?php

namespace App\Providers;

use App\Listeners\SendPasswordUpdatedNotification;
use Illuminate\Auth\Events\{PasswordReset, Registered};
use Illuminate\Auth\Listeners\{SendEmailVerificationNotification};
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PasswordReset::class => [
            SendPasswordUpdatedNotification::class
        ]
    ];

    public function boot(): void
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
