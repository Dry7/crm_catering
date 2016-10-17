<?php

namespace App\Repository;

use App\Criteria\UserIDCriteria;

class EventRepository extends BaseRepository
{
    function model()
    {
        return 'App\\Models\\Event';
    }
}