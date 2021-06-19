<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MediaRequest extends FormRequest
{
    public function authorize()
    {
        if (!Auth::user()) {
            return false;
        }
        return true;
    }

    public function rules()
    {
        return [
            'image' => 'required|array',
            'image.*' => 'image',
        ];
    }
}
