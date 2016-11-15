<?php

namespace App\Repository;

use App\Criteria\UserIDCriteria;
use Illuminate\Support\Facades\Auth;

class LogRepository extends BaseRepository
{
    function model()
    {
        return 'App\\Models\\Log';
    }
}