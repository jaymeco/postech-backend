<?php

namespace App\Infra\Repositories\Eloquent;

use App\Exceptions\ApplicationException;
use App\Models\Customer as Model;
use Core\Application\Contracts\Repositories\CustomerRepository;
use Core\Domain\Entities\Customer;

class CustomerEloquentRepository extends EloquentRepository implements CustomerRepository
{
    public function __construct()
    {
        parent::__construct(Model::class);
    }
    public function save(Customer $customer): void
    {
        $this->query->create([
            Model::UUID => $customer->getUuid()->getValue(),
            Model::NAME => !is_null($customer->getName()) ? $customer->getName()->getValue() : null,
            Model::EMAIL => !is_null($customer->getEmail()) ? $customer->getEmail()->getValue() : null,
            Model::CPF => !is_null($customer->getCpf()) ? $customer->getCpf()->getValue() : null,
            Model::CUSTOMER_TYPE => $customer->getType()->getValue(),
        ]);
    }

    public function getByUuid(string $uuid): Customer
    {
        $model = $this->query->where(Model::UUID, value: $uuid)->first();

        throw_if(is_null($model), ApplicationException::notFound('customer', 'uuid'));

        return Customer::restore(
            $model->uuid,
            $model->type,
            $model->cpf,
            $model->name,
            $model->email,
        );
    }
}
