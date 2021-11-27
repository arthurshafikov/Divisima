<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Services\MailService;

class MailController extends Controller
{
    public function contact(ContactRequest $request)
    {
        app(MailService::class)->sendContactEmail($request->validated());
    }
}
