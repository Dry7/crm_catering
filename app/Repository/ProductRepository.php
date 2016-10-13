<?php

namespace App\Repository;

use App\Criteria\UserIDCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class ProductRepository extends BaseRepository
{
    function model()
    {
        return 'App\\Models\\Product';
    }
}