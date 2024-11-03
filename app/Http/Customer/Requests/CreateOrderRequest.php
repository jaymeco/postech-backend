<?php

namespace App\Http\Customer\Requests;

use App\Http\Requests\ApiRequest;

class CreateOrderRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'products' => 'present|array|max:50',
            'products.*' => 'required|string',
            'customer_cpf' => 'sometimes|string|max:11',
        ];
    }

    public function getProducts()
    {
        return $this->post('products');
    }

    public function getCustomerCpf()
    {
        return $this->post('customer_cpf');
    }
}
