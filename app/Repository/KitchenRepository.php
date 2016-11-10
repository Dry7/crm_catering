<?php

namespace App\Repository;

use App\Criteria\UserIDCriteria;

class KitchenRepository extends BaseRepository
{
    function model()
    {
        return 'App\\Models\\Kitchen';
    }
}