<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;


class StoreEmployee extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'division' => 'required|uuid|exists:divisions,id', // Validasi UUID divisi
            'position' => 'required|string|max:255'

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
