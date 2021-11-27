<?php

namespace App\Services;

use App\Jobs\SendEmail;

class MailService
{
    public function sendContactEmail(array $data): void
    {
        dispatch(new SendEmail($data));
    }
}
