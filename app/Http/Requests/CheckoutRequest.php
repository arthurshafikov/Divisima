<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            "address" => "required|string",
            "country" => "required|string",
            "zip" => "required",
            "phone" => "required",
            "delivery" => "required",
        ];
        if(\Auth::id() === null){
            $rules = array_merge($rules,[
                "first_name" => "required",
                "surname" => "required",
                "email" => "required|email|unique:users",
                "name" => "required|string|unique:users",
                "password" => "confirmed",
            ]);
        }
        return $rules;
    }
}
