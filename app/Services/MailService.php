<?php

namespace App\Services;

use App\Jobs\SendEmailJob;
use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\User;
use App\Notifications\EmailChangedUserNotification;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public function sendContactEmail(array $data): void
    {
        dispatch(new SendEmailJob($data));
    }

    public function sendOrderEmails(Order $order): void
    {
        Mail::to(config('mail.admin.address'))->send(new OrderMail($order, __('email.admin.title')));
        Mail::to($order->user->email)->send(new OrderMail($order, __('email.client.title')));
    }

    public function sendUserNotificationAboutChangedEmail(User $user): void
    {
        $user->notify(new EmailChangedUserNotification($user));
    }

    public function sendUserVerificationEmail(User $user): void
    {
        $user->sendEmailVerificationNotification();
    }
}
