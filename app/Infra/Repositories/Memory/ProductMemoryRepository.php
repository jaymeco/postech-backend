<?php

namespace App\Infra\Repositories\Memory;

use Core\Application\Contracts\Repositories\ProductRepository;
use Core\Domain\Entities\Product;
use Error;

class ProductMemoryRepository implements ProductRepository
{
    /***@var Product[] */
    private array $database;

    public function __construct()
    {
        $this->database = [];
    }

    public function save(Product $product): void
    {
        $this->database[] = $product;
    }

    public function getByUuid(string $uuid): Product
    {
        $founds = array_filter($this->database, function ($product) use ($uuid) {
            return $product->getUuid()->equals($uuid);
        });

        if (count($founds) <= 0) {
            // TODO Criar exceptions da aplicacao
            throw new Error('Not found');
        }

        return $founds[array_key_first($founds)];
    }

    public function update(Product $product): void
    {
        $this->database = array_map(function ($data) use ($product) {
            if ($data->getUuid()->equals($product->getUuid())) {
                return $product;
            }

            return $data;
        }, $this->database);
    }

    public function all(?string $categoryUuid = null): array
    {
        return array_filter($this->database, function ($product) use ($categoryUuid) {
            if (!is_null($categoryUuid)) {
                return $product->getCategory()->getUuid()->equals($categoryUuid);
            }

            return is_null($categoryUuid);
        });
    }

    public function delete(Product $product): void
    {
        $this->database = array_filter($this->database, function ($data) use ($product) {
            return !($data->getUuid()->equals($product->getUuid()));
        });
    }
}
