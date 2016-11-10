<?php

namespace App\Repository;

use Prettus\Repository\Eloquent\BaseRepository as OldBaseRepository;

abstract class BaseRepository extends OldBaseRepository
{
    public function getModel()
    {
        return $this->model;
    }
}