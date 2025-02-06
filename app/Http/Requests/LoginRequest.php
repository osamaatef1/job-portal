<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required_without_all:mobile_number,username|email',
            'mobile_number' => 'required_without_all:email,username',
            'username' => 'required_without_all:email,mobile_number',
            'password' => 'required|string|min:6',
        ];
    }
}