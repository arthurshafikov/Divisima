<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Services\MailService;

class SendEmails
{
    public function handle(OrderPlaced $event)
    {
        app(MailService::class)->sendOrderEmails($event->order);
    }
}
