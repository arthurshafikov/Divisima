<?php

namespace App\Listeners;

use App\Events\UserEmailHadChanged;

class SendVerificationEmail
{
    public function handle(UserEmailHadChanged $event)
    {
        $event->user->sendEmailVerificationNotification();
    }
}
