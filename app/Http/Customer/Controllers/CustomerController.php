<?php

namespace App\Http\Customer\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Customer\Requests\CreateCustomerRequest;
use Core\Application\UseCases\CreateCustomerUseCase;

class CustomerController extends Controller
{
    public function create(CreateCustomerRequest $request)
    {
        $useCase = app(CreateCustomerUseCase::class);

        $customer = $useCase->execute($request->getEmail(), $request->getName());

        return response()->json(
            [
                'uuid' => $customer->getUuid()->getValue(),
                'name' => $customer->getName()->getValue(),
                'email' => $customer->getEmail()->getValue(),
                'cpf' => is_null($customer->getCpf()) ? null : $customer->getCpf()->getValue(),
                'type' => $customer->getType()->getValue(),
            ], 200);
    }
}
