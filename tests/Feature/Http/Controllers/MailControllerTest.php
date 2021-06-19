<?php

namespace Tests\Feature\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class MailControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testContactEmailSend()
    {
        Mail::fake();
        $data = [
            'name' => 'Test',
            'email' => 'fakeemail@test.com',
            'subject' => 'subject',
            'message' => 'big message to someone',
        ];

        $response = $this->post(route('contactEmail'), $data);

        $response->assertOk();
        Mail::assertSent(ContactMail::class);
    }
}
