<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

// Events
use App\Events\UserAuthenticated;
use App\Events\UserLoggedOut;
use App\Events\InvoiceCreated;
use App\Events\OtpGenerated;
use App\Events\ThreadViewed;

// Listeners
use App\Listeners\CreateLoggedInAction;
use App\Listeners\CreateLoggedOutAction;
use App\Listeners\CreateRegisteredAction;
use App\Listeners\AssignCoursesToUser;
use App\Listeners\SendOtpSmsToUser;
use App\Listeners\IncreaseViews;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            CreateRegisteredAction::class
        ],
        UserAuthenticated::class => [
            CreateLoggedInAction::class
        ],
        UserLoggedOut::class => [
            CreateLoggedOutAction::class
        ],
        InvoiceCreated::class => [
            AssignCoursesToUser::class
        ],
        OtpGenerated::class => [
            SendOtpSmsToUser::class
        ],
        ThreadViewed::class => [
            IncreaseViews::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
