<?php

namespace App\Http\Requests;

use App\Traits\ReturnResponser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CountryRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => 'required|string',
                    'capital' => 'required|string',
                    'iso2' => 'required|string',
                    'iso3' => 'required|string',
                    'phone_code' => 'required|string',
                    'currency' => 'required|string',
                    'flag' => 'required|string',
                ];  
            case 'PUT':
                return [
                    'name' => 'sometimes|string',
                    'capital' => 'sometimes|string',
                    'iso2' => 'sometimes|string',
                    'iso3' => 'sometimes|string',
                    'phone_code' => 'sometimes|string',
                    'currency' => 'sometimes|string',
                    'flag' => 'sometimes|string',
                ];  
            default:
                return [];
        }

    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->errorvalidator($this->validator->errors()->messages()));
    }
}
