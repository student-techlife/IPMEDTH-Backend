<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Auth;

/**
 * @OA\Schema(required={"date", "patient_id"})
 */
class SessionRequest extends FormRequest
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
     * @OA\Property(type="date", example="20-05-2022", description="Date the session will take place", property="date"),
     * @OA\Property(type="integer", format="int64", example="1", description="ID of the patient linked to this session", property="patient_id"),
     */
    public function rules()
    {
        return [
            'date' => 'required|date',
            'patient_id' => 'required|exists:patients,id,'.$this->session->id,
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
