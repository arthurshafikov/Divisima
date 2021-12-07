<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{
    public function rules()
    {
        return [
            'qty' => ['required', 'numeric'],
            'attributes' => ['nullable', 'array'],
            'attributes.*' => ['string'],
        ];
    }
}
