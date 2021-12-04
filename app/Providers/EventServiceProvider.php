<?php

namespace App\Providers;

use App\Events\OrderPlaced;
use App\Events\ProductViewed;
use App\Events\UserEmailHadChanged;
use App\Listeners\AddViewedCookie;
use App\Listeners\IncrementProductsTotalSales;
use App\Listeners\NotifyUserAboutChangedEmail;
use App\Listeners\SendEmails;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ProductViewed::class => [
            AddViewedCookie::class,
        ],
        OrderPlaced::class => [
            IncrementProductsTotalSales::class,
            SendEmails::class,
        ],
        UserEmailHadChanged::class => [
            NotifyUserAboutChangedEmail::class,
        ],
    ];
}
