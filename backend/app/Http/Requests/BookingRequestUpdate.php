<?php

namespace App\Http\Requests;

use App\Traits\ReturnResponser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class BookingRequestUpdate extends FormRequest
{
    use ReturnResponser;

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
            'name' => 'sometimes|string',
            'email' => 'sometimes|string|email',
            'country_id' => 'sometimes|numeric',
            'whatsapp_number' => 'sometimes|string',
            'surfing_experience' => 'sometimes|string',
            'visit_date' => 'sometimes|date',
            'desired_board' => 'sometimes|string',
            'identification_id' => 'sometimes|mimes:jpeg,jpg,png,pdf'
        ];
        
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->errorvalidator($this->validator->errors()->messages()));
    }
}
