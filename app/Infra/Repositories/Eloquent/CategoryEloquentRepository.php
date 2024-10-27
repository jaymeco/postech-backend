<?php

namespace App\Infra\Repositories\Eloquent;

use App\Exceptions\ApplicationException;
use App\Models\Category as Model;
use Core\Application\Contracts\Repositories\CategoryRepository;
use Core\Domain\Entities\Category;

class CategoryEloquentRepository extends EloquentRepository implements CategoryRepository
{
    public function __construct()
    {
        parent::__construct(Model::class);
    }

    public function getByUuid(string $uuid): Category
    {
        $model = $this->query->where(Model::UUID, '=', $uuid)->first();

        throw_if(is_null($model), ApplicationException::notFound('category', 'uuid'));

        return Category::restore($model->uuid, $model->name);
    }
}
