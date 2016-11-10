<?php

namespace App\Repository;

use App\Criteria\UserIDCriteria;

class ProductRepository extends BaseRepository
{
    function model()
    {
        return 'App\\Models\\Product';
    }

    public function getModel()
    {
        return $this->model;
    }
}