<?php

namespace App\Infra\Integrations;

use App\Infra\Integrations\Http\HttpClient;
use Core\Application\Contracts\Services\PaymentService;
use Core\Application\Dtos\PaymentData;
use Core\Application\Dtos\PaymentRequest;
use Core\Application\Dtos\QrPaymentData;

class MockPaymentService implements PaymentService
{
    public function __construct(
        private readonly HttpClient $client,
    ) {}

    public function requestQrCode(PaymentRequest $request): QrPaymentData
    {
        $response = $this->client->post('/api/mock/qrs', [
            'amout' => $request->amount,
            'code' => $request->code,
            'notification_url' => $request->notificationUrl,
        ]);

        return new QrPaymentData($response->data->qr_data);
    }

    public function findPaymentById(string $id): PaymentData
    {
        return new PaymentData('approved', '2017-08-31T11:26:38.000Z');
    }
}
