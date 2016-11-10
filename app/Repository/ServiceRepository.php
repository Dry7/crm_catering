<?php

namespace App\Repository;

use App\Criteria\UserIDCriteria;

class ServiceRepository extends BaseRepository
{
    function model()
    {
        return 'App\\Models\\Service';
    }
}