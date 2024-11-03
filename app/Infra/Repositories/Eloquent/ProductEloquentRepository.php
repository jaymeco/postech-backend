<?php

namespace App\Infra\Repositories\Eloquent;

use App\Exceptions\ApplicationException;
use App\Models\Category as CategoryModel;
use Core\Application\Contracts\Repositories\ProductRepository;
use Core\Domain\Entities\Product;
use App\Models\Product as Model;
use Core\Domain\Entities\Category;

class ProductEloquentRepository extends EloquentRepository implements ProductRepository
{
    public function __construct()
    {
        parent::__construct(Model::class);
    }

    public function save(Product $product): void
    {
        $this->query->create([
            Model::UUID => $product->getUuid()->getValue(),
            Model::CATEGORY_ID => CategoryModel::where('uuid', '=', $product->getCategory()->getUuid()->getValue())
            ->first()->id,
            Model::NAME => $product->getName()->getValue(),
            Model::DESCRIPTION => $product->getDescription(),
            Model::PRICE => $product->getPrice()->getValue(),
            Model::IMAGE_URI => $product->getImageUri(),
        ]);
    }

    public function update(Product $product): void
    {
        $this->query
            ->where(Model::UUID, '=', $product->getUuid()->getValue())
            ->update([
                Model::CATEGORY_ID => CategoryModel::where('uuid', '=', $product->getCategory()->getUuid()->getValue())
                    ->first()->id,
                Model::NAME => $product->getName()->getValue(),
                Model::DESCRIPTION => $product->getDescription(),
                Model::PRICE => $product->getPrice()->getValue(),
                Model::IMAGE_URI => $product->getImageUri(),
            ]);
    }

    public function all(?string $categoryUuid = null): array
    {
        $query = $this->query->newQuery();

        if (!is_null($categoryUuid)) {
            $query->whereHas('category', function ($query) use ($categoryUuid) {
                $query->where(CategoryModel::UUID, '=', $categoryUuid);
            });
        }

        return $query->get()->map(fn(Model $model) => Product::restore(
            $model->uuid,
            $model->name,
            $model->description,
            Category::restore($model->category->uuid, $model->category->name),
            $model->image_uri,
            $model->price,
        ))->toArray();
    }

    public function getByUuid(string $uuid): Product
    {
        $model = Model::where(Model::UUID, '=',$uuid)->first();

        throw_if(is_null($model), ApplicationException::notFound('product', 'uuid'));

        return Product::restore(
            $model->uuid,
            $model->name,
            $model->description,
            Category::restore($model->category->uuid, $model->category->name),
            $model->image_uri,
            $model->price,
        );
    }

    public function delete(Product $product): void
    {
        $this->query->where(Model::UUID, '=', $product->getUuid()->getValue())
            ->delete();
    }
}
