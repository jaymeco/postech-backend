<?php

namespace App\Infra\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;

class EloquentRepository
{
    protected Builder $query;

    protected function __construct(
        string $model
    ) {

        $this->query = app($model)->newQuery();
    }
}
