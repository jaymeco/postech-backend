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

        return response()->json($customer, 200);
    }
}
