<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DeleteImagesRequest extends FormRequest
{
    public function rules()
    {
        return [
            'image_ids' => 'array',
            'image_ids.*' => 'numeric',
        ];
    }
}
