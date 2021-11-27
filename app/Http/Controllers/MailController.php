<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Jobs\SendEmail;

class MailController extends Controller
{
    public function contact(ContactRequest $request)
    {
        $data = $request->only(['name','email','subject','message']);
        dispatch(new SendEmail($data));
    }
}
