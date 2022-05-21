<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Auth;

/**
 * @OA\Schema(required={"session_id", "hand_type", "finger_1", "finger_2", "finger_3", "finger_4", "finger_5"})
 */
class StoreMeasurementRequest extends FormRequest
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
     * @OA\Property(type="integer", format="int64", example=1, description="Session id", property="session_id")
     * @OA\Property(type="string", example="left", description="hand_type", property="hand_type"),
     * @OA\Property(type="string", example="{}", description="Thumb", property="finger_1"),
     * @OA\Property(type="string", example="{}", description="Index finger", property="finger_2"),
     * @OA\Property(type="string", example="{}", description="Middle finger", property="finger_3"),
     * @OA\Property(type="string", example="{}", description="Ring finger", property="finger_4"),
     * @OA\Property(type="string", example="{}", description="Little finger", property="finger_5"),
     */
    public function rules()
    {
        return [
            'session_id' => [
                'required',
                Rule::exists('sessions', 'id')],
            'hand_type' => 'required|in:left,right',
            'finger_1' => 'required|json',
            'finger_2' => 'required|json',
            'finger_3' => 'required|json',
            'finger_4' => 'required|json',
            'finger_5' => 'required|json',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'hand_type.in' => 'The selected hand type is invalid, choose between left or right.',
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