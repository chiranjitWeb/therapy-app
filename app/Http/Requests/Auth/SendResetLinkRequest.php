<?php

namespace App\Http\Requests\Auth;
use Illuminate\Foundation\Http\FormRequest;

class SendResetLinkRequest extends FormRequest
{
    public function authorize()
    {
        return true; // allow all users
    }

    public function rules()
    {
        return [
            'email' => ['required', 'email'],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Please enter your email.',
            'email.email' => 'Enter a valid email address.',
        ];
    }
}
