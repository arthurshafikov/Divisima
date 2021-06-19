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

    public $order;
    public $title;
    public $site_url;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, string $title)
    {
        $this->order = $order;
        $this->title = $title;
        $this->site_url = \App::make('url')->to('/');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New order!')
                    ->view('emails.order');
    }
}
