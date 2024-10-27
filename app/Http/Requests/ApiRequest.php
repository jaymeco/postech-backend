<?php

namespace App\Http\Requests;

use App\Constants\ValidationRules;
use App\Exceptions\RequestException;
use Error;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

abstract class ApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function messages()
    {
        return [
            'required' => ValidationRules::REQUIRED,
            'type' => ValidationRules::TYPE,
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw RequestException::create($validator);
    }
}
