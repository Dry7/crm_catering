<?php

namespace App\Repository;

use Prettus\Repository\Eloquent\BaseRepository as OldBaseRepository;

abstract class BaseRepository extends OldBaseRepository
{
    public function create(array $attributes)
    {
        $attributes = array_where($attributes, function ($value) {
            return (string)$value !== '';
        });
        return parent::create($attributes);
    }

    public function update(array $attributes, $id)
    {
        $attributes = array_where($attributes, function ($value) {
            return (string)$value !== '';
        });
        return parent::update($attributes, $id);
    }
}