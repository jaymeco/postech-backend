<?php

namespace App\Http\Webhook\Controllers;

use App\Http\Controllers\Controller;
use App\Infra\Adapters\Dtos\ProcessPaymentAdapter;
use Core\Application\UseCases\ProcessPaymentUseCase;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct() {}

    public function processPayment(Request $request, string $orderUuid)
    {
        $processData = ProcessPaymentAdapter::parse($request->input());

        $useCase = app(ProcessPaymentUseCase::class);

        $useCase->execute($processData, $orderUuid);

        return response()->json();
    }
}
