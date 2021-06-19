<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailChangedUserNotification extends Notification
{
    use Queueable;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('Email was changed')
            ->line(
                "Your email {$notifiable->email} on " . env('APP_NAME')
                . " had been changed. If you want to return it back, you should contact website administrator."
            )->action('Contact Form', route('contact'));
    }
}
