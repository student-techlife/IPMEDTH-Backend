<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Auth;

/**
 * @OA\Schema(required={"name", "email"})
 */
class PatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    /**
     * @OA\Property(format="string", default="Jane", description="name", property="name"),
     * @OA\Property(format="date", default="1990-01-01", description="birthdate", property="date_of_birth"),
     * @OA\Property(format="email", default="jane@doe.com", description="email", property="email"),
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'date_of_birth' => 'date|nullable',
            'email' => 'required|email|unique:patients,email,'.$this->patient->id,
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $response = response()->json([
            'success' => false,
            'message' => 'Validation Error.',
            'details' => $errors->messages(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
