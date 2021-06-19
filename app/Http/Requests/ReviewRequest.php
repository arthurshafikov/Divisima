<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ReviewRequest extends FormRequest
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
            'text' => 'required|min:5|max:500',
            'rating' => 'required|digits:1',
        ];
    }
}
