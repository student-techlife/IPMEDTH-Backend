<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Auth;

/**
 * @OA\Schema(required={"name", "email"})
 */
class StorePatientRequest extends FormRequest
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
     * @OA\Property(type="string", example="Jane", description="Name of the patient", property="name"),
     * @OA\Property(type="date", example="1990-01-01", description="Birthday of patient", property="date_of_birth"),
     * @OA\Property(type="email", example="jane@doe.com", description="Email of the patient", property="email"),
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'date_of_birth' => 'date|nullable',
            'email' => [
                'required',
                'email',
                Rule::unique('patients', 'email')],
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