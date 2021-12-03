<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Mail\OrderMail;
use Illuminate\Support\Facades\Mail;

class SendEmails
{
    public function handle(OrderPlaced $event)
    {
        $order = $event->order;
        $title = __('email.admin.title');
        Mail::to(config('mail.admin.address'))->send(new OrderMail($order, $title));
        $title = __('email.client.title');
        Mail::to($order->user->email)->send(new OrderMail($order, $title));
    }
}
