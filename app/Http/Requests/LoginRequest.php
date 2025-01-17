<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Username is required.',
            'username.string'   => 'Username must be a string.',
            'username.max'      => 'Username cannot exceed 255 characters.',
            'password.required' => 'Password is required.',
            'password.string'   => 'Password must be a string.',
            'password.min'      => 'Password must be at least 6 characters long.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {

        $response = response()->json([
            'status' => 'error',
            'message' => 'Validation failed.',
            'errors' => $validator->errors(),
        ], 422);

        throw new ValidationException($validator, $response);
    }
}
