<?php

namespace App\Listeners;

use App\Events\UserEmailHadChanged;
use App\Services\MailService;

class NotifyUserAboutChangedEmail
{
    public function handle(UserEmailHadChanged $event)
    {
        app(MailService::class)->sendUserNotificationAboutChangedEmail($event->user);
    }
}
