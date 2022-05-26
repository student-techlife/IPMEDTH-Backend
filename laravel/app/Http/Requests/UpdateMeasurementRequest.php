<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Auth;

/**
 * @OA\Schema(required={"session_id", "hand_view", "hand_type", "hand_score", "finger_thumb", "finger_index", "finger_middle", "finger_ring", "finger_pink"})
 */
class UpdateMeasurementRequest extends FormRequest
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
     * @OA\Property(type="string", example="left", description="The hand that was photographed", property="hand_type"),
     * @OA\Property(type="string", example="thumb_side", description="What angle was the photo taken from", property="hand_view"),
     * @OA\Property(type="number", format="float", example=0.85, description="The score of the hand", property="hand_score"),
     * @OA\Property(type="string", example="{}", description="Thumb", property="finger_thumb"),
     * @OA\Property(type="string", example="{}", description="Index finger", property="finger_index"),
     * @OA\Property(type="string", example="{}", description="Middle finger", property="finger_middle"),
     * @OA\Property(type="string", example="{}", description="Ring finger", property="finger_ring"),
     * @OA\Property(type="string", example="{}", description="Little finger", property="finger_pink"),
     */
    public function rules()
    {
        return [
            'session_id' => [
                'required',
                Rule::exists('sessions', 'id')],
            'hand_type' => 'required|in:left,right',
            'hand_view' => [
                'required',
                Rule::in(['thumb_side', 'pink_side', 'finger_side', 'back_side'])],
            'hand_score' => 'required|numeric|min:0|max:1',
            'finger_thumb' => 'required|json',
            'finger_index' => 'required|json',
            'finger_middle' => 'required|json',
            'finger_ring' => 'required|json',
            'finger_pink' => 'required|json',
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
            'hand_view.in' => 'The selected hand view is invalid, choose between thumb_side, pink_side, finger_side or back_side.',
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
