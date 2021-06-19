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
        $title = 'New client order!';
        Mail::to(config('mail.admin.address'))->send(new OrderMail($order, $title));
        $title = 'Thank you for your order!';
        Mail::to($order->user->email)->send(new OrderMail($order, $title));
    }
}
