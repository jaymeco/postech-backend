<?php

namespace App\Http\Mock\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Mock\Requests\SendQrCodeRequest;

class MockPaymentController extends Controller
{
    public function __construct() {}

    public function sendQrCode(SendQrCodeRequest $request)
    {
        $client = new \GuzzleHttp\Client();
        $client->post($request->getNotificationUrl(), [
            'json' => ['paymentId' => 1]
        ]);


        return response()->json([
            'qr_data' => 'AA00020101021243650016COM.MERCADOLIBRE02013063638f1192a-5fd1-4180-a180-8bcae3556bc35204000053039865802BR5925IZABEL AAAA DE MELO6007BARUERI62070503***63040B6D'
        ]);
    }
}
