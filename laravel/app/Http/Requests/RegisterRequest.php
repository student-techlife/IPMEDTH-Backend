<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(required={"name", "email", "password"})
 */
class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    /**
     * @OA\Property(type="string", example="Jane", description="Name of the user", property="name"),
     * @OA\Property(type="email", example="jane@doe.com", description="Email from the user", property="email"),
     * @OA\Property(type="string", example="password", description="The password you want to use", property="password"),
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('users')
            ],
            'password' => 'required|string|min:6',
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
            'message' => 'The given data was invalid.',
            'errors' => $errors->messages(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
