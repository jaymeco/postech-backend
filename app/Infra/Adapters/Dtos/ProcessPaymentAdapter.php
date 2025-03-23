<?php

namespace App\Infra\Adapters\Dtos;

use Core\Application\Dtos\ProcessPaymentDto;

abstract class ProcessPaymentAdapter
{
    public static function parse(array $data) {
        if(env('APP_ENV') == 'local') {
            return new ProcessPaymentDto($data['paymentId']);
        }

        return new ProcessPaymentDto($data['data']['id']);
    }
}
