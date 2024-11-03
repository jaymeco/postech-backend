<?php

namespace App\Infra\Repositories\Memory;

use Core\Application\Contracts\Repositories\CategoryRepository;
use Core\Domain\Base\Enums\CategoryEnum;
use Core\Domain\Entities\Category;
use Error;

class CategoryMemoryRepository implements CategoryRepository {
    /***@var Category[] */
    private array $database;

    public function __construct()
    {
        $this->database = [
            Category::restore(CategoryEnum::DESSERT->key(), CategoryEnum::DESSERT->name()),
            Category::restore(CategoryEnum::DRINK->key(), CategoryEnum::DRINK->name()),
            Category::restore(CategoryEnum::GARNISH->key(), CategoryEnum::GARNISH->name()),
            Category::restore(CategoryEnum::SNACK->key(), CategoryEnum::SNACK->name()),
        ];
    }

    public function getByUuid(string $uuid): Category
    {
        $founds = array_filter($this->database, function ($category) use ($uuid) {
            return $category->getUuid()->equals($uuid);
        });

        if (count($founds) <= 0 || is_null($founds)) {
            // TODO Criar exceptions da aplicacao
            throw new Error('Not found');
        }

        return $founds[array_key_first($founds)];
    }
}
