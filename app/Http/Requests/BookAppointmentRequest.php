<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BookAppointmentRequest extends FormRequest
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
            'healthcare_professional_id' => ['required','exists:healthcare_professionals,id'],
            'appointment_start_time' => ['required','date','after:now'],
            'appointment_end_time' => ['required','date','after:appointment_start_time'],
            'notes' => ['nullable','string','max:2000'],
        ];
    }

    /**
     * Get validation custom messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'appointment_start_time.after' => trans('validation.appointment_start_time.after'),
            'appointment_end_time.after' => trans('validation.appointment_end_time.after'),
        ];
    }

    /**
     * @param Validator $validator
     *
     * @return array
     */
    protected function failedValidation(Validator $validator): array
    {
        throw new HttpResponseException(
            response()->json([
                'status'  => false,
                'message' => 'Validation errors',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
}
