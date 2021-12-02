<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public Order $order;
    public string $title;
    public string $siteUrl;

    public function __construct(Order $order, string $title)
    {
        $this->order = $order;
        $this->title = $title;
        $this->siteUrl = app()->make('url')->to('/');
    }

    public function build()
    {
        return $this->subject('New order!')
            ->view('emails.order');
    }
}
