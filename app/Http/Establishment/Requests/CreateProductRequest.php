<?php

namespace App\Http\Establishment\Requests;

use App\Http\Requests\ApiRequest;

class CreateProductRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'category_uuid' => 'required|string',
            'image_uri' => 'required|string',
            'price' => 'required|numeric',
        ];
    }

    public function getName()
    {
        return $this->post('name');
    }

    public function getDescription()
    {
        return $this->post('description');
    }

    public function getCategoryUuid()
    {
        return $this->post('category_uuid');
    }

    public function getImageUri()
    {
        return $this->post('image_uri');
    }

    public function getPrice()
    {
        return $this->post('price');
    }
}
