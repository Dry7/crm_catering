<?php

namespace App\Repository;

use App\Criteria\UserIDCriteria;

class ClientRepository extends BaseRepository
{
    public function boot()
    {
        $this->pushCriteria(UserIDCriteria::class);

        parent::boot();
    }

    function model()
    {
        return 'App\\Models\\Client';
    }
}