<?php

namespace App\Repository;

use App\Criteria\UserIDCriteria;

class TypeRepository extends BaseRepository
{
    function model()
    {
        return 'App\\Models\\Type';
    }
}