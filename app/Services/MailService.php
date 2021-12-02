<?php

namespace App\Services;

use App\Jobs\SendEmailJob;

class MailService
{
    public function sendContactEmail(array $data): void
    {
        dispatch(new SendEmailJob($data));
    }
}
