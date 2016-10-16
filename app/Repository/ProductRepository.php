<?php

namespace App\Repository;

use App\Criteria\UserIDCriteria;

class ProductRepository extends BaseRepository
{
    function model()
    {
        return 'App\\Models\\Product';
    }

    public function create(array $attributes)
    {
        $attributes = array_where($attributes, function ($value) {
            return (string)$value !== '';
        });
        return parent::create($attributes);
    }
}