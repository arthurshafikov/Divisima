<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function contact(ContactRequest $request)
    {
        $data = $request->only(['name','email','subject','message']);
        // SendEmail::dispatch($data);
        Mail::to(config('mail.admin.address'))->send(new ContactMail($data));
    }
}
