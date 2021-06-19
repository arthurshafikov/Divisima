<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CheckoutRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            "address" => "required|string",
            "country" => "required|string",
            "zip" => "required",
            "phone" => "required",
            "delivery" => "required",
        ];
        if (Auth::id() === null) {
            $rules = array_merge($rules, [
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
