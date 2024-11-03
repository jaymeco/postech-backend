<?php

namespace App\Http\Customer\Requests;

use App\Http\Requests\ApiRequest;

class CreateCustomerRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string',
        ];
    }

    public function getName()
    {
        return $this->post('name');
    }

    public function getEmail()
    {
        return $this->post('email');
    }
}
