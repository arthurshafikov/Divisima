<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MediaRequest extends FormRequest
{
    public function authorize()
    {
        return (bool)Auth::user();
    }

    public function rules()
    {
        return [
            'image' => 'required|array',
            'image.*' => 'image',
        ];
    }
}
