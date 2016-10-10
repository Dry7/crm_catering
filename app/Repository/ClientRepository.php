<?php

namespace App\Repository;

use App\Criteria\UserIDCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

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