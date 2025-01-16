<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;


class UpdateEmployee extends FormRequest
{
    /**
     * Tentukan apakah pengguna dapat membuat permintaan ini.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Tentukan aturan validasi untuk permintaan ini.
     */
    public function rules()
    {
        return [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'division' => 'required|exists:divisions,id',
            'position' => 'required|string|max:255',
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

