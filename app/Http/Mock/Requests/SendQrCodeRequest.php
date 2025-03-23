<?php

namespace App\Http\Mock\Requests;

use App\Http\Requests\ApiRequest;

class SendQrCodeRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'amount' => 'sometimes|numeric',
            'code' => 'sometimes|string',
            'notification_url' => 'sometimes|string'
        ];
    }

    public function getNotificationUrl()
    {
        return $this->post('notification_url');
    }
}
