<?php

namespace App\Http\Requests;

use App\Traits\ReturnResponser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class BookingRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|string|email',
            'country_id' => 'required|numeric',
            'whatsapp_number' => 'required|string',
            'surfing_experience' => 'required|string',
            'visit_date' => 'required|date',
            'desired_board' => 'required|string',
            'identification_id' => 'required|mimes:jpeg,jpg,png,pdf'
        ];  
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->errorvalidator($this->validator->errors()->messages()));
    }
}
