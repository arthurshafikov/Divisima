<?php

namespace App\Listeners;

use App\Events\UserEmailHadChanged;
use App\Notifications\EmailChangedUserNotification;

class NotifyUserAboutChangedEmail
{
    public function handle(UserEmailHadChanged $event)
    {
        $event->user->notify(new EmailChangedUserNotification($event->user));
    }
}
