<?php

namespace App\Listeners;

use App\Events\UserEmailHadChanged;
use App\Services\MailService;

class SendVerificationEmail
{
    public function handle(UserEmailHadChanged $event)
    {
        app(MailService::class)->sendUserVerificationEmail($event->user);
    }
}
