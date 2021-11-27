<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CheckoutRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            "address" => "required|string",
            "country" => "required|string",
            "zip" => "required",
            "phone" => "required",
            "delivery" => [
                "required",
                Rule::in(Order::ORDER_DELIVERY_METHODS),
            ],
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
