<?php

namespace App\Infra\Repositories\Memory;

use Core\Application\Contracts\Repositories\OrderRepository;
use Core\Application\Contracts\Repositories\ProductRepository;
use Core\Domain\Entities\Order;
use Core\Domain\Entities\Product;
use Error;

class OrderMemoryRepository implements OrderRepository
{
    /***@var Order[] */
    private array $database;

    public function __construct()
    {
        $this->database = [];
    }

    public function save(Order $order): void
    {
        $this->database[] = $order;
    }

    public function update(Order $order): void
    {
        $this->database = array_map(function ($data) use ($order) {
            if ($data->getUuid()->equals($order->getUuid())) {
                return $order;
            }

            return $data;
        }, $this->database);
    }

    public function getByUuid(string $uuid): Order
    {
        $founds = array_filter($this->database, function ($order) use ($uuid) {
            return $order->getUuid()->equals($uuid);
        });

        if (count($founds) <= 0 || is_null($founds)) {
            // TODO Criar exceptions da aplicacao
            throw new Error('Not found');
        }

        return $founds[array_key_first($founds)];
    }

    public function all(): array
    {
        return $this->database;
    }
}
