<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|nullable',
            'email' => 'email|nullable',
            'password' => 'string|nullable|min:8',
            'password_confirmation' => 'string|nullable|required_with:password|same:password',
        ];
    }

    public function messages()
    {
        return [
            'email' => [
                'email' => 'Must be a valid email address.',
            ],
            'password' => [
                'min' => 'Password must be at least 8 characters.',
            ],
            'password_confirmation' => [
                'required_with' => 'Please confirm password.',
                'same' => 'Passwords do not match.'
            ],
        ];
    }
}
