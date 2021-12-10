<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LoadGalleryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'gallery' => 'array',
            'gallery.*' => 'string',
        ];
    }
}
