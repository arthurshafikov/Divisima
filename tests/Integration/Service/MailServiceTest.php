<?php

namespace Tests\Integration\Service;

use App\Jobs\SendEmailJob;
use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\User;
use App\Notifications\EmailChangedUserNotification;
use App\Services\MailService;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class MailServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function testSendContactEmail()
    {
        $this->expectsJobs(SendEmailJob::class);

        app(MailService::class)->sendContactEmail([]);
    }

    public function testSendOrderEmails()
    {
        Mail::fake();
        $order = Order::factory()->create();
        $user = $order->user;

        app(MailService::class)->sendOrderEmails($order);

        Mail::assertSent(OrderMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
        Mail::assertSent(OrderMail::class, function ($mail) {
            return $mail->hasTo(config('mail.admin.address'));
        });
    }

    public function testSendUserNotificationAboutChangedEmail()
    {
        Notification::fake();
        $user = User::factory()->create();

        app(MailService::class)->sendUserNotificationAboutChangedEmail($user);

        Notification::assertSentTo($user, EmailChangedUserNotification::class);
    }

    public function testSendUserVerificationEmail()
    {
        Notification::fake();
        $user = User::factory()->create();

        app(MailService::class)->sendUserVerificationEmail($user);

        Notification::assertSentTo($user, VerifyEmail::class);
    }
}
