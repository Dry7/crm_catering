<?php

namespace App\Repository;

use App\Criteria\UserIDCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class ServiceRepository extends BaseRepository
{
    function model()
    {
        return 'App\\Models\\Service';
    }
}