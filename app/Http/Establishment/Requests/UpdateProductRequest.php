<?php

namespace App\Http\Establishment\Requests;

use App\Http\Requests\ApiRequest;

class UpdateProductRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|string|max:50',
            'description' => 'sometimes|string|max:255',
            'category_uuid' => 'sometimes|string',
            'image_uri' => 'sometimes|string',
            'price' => 'sometimes|numeric',
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
