<?php

namespace App\Repository;

use Prettus\Repository\Eloquent\BaseRepository as OldBaseRepository;

abstract class BaseRepository extends OldBaseRepository
{
    public function getModel()
    {
        return $this->model;
    }

    public function create(array $attributes)
    {
        return parent::create(self::checkNull($attributes));
    }

    public function update(array $attributes, $id)
    {
        return parent::update(self::checkNull($attributes), $id);
    }

    public static function checkNull($attributes)
    {
        foreach ($attributes as $key => $attribute) {
            if ($attribute === '') {
                $attributes[$key] = null;
            }
        }

        return $attributes;
    }
}