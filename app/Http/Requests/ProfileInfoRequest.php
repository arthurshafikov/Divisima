<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileInfoRequest extends FormRequest
{
    public function authorize()
    {
        return (bool)Auth::user();
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string',
            'surname' => 'required|string',
            'address' => 'required|string',
            'country' => 'required|string',
            'zip' => 'required|string',
            'phone' => 'required|string',
        ];
    }
}
