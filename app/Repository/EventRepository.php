<?php

namespace App\Repository;

use App\Criteria\UserIDCriteria;

class EventRepository extends BaseRepository
{
    public function boot()
    {
        $this->pushCriteria(UserIDCriteria::class);

        parent::boot();
    }

    function model()
    {
        return 'App\\Models\\Event';
    }

    /**
     * Update a entity in repository by id
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     * @param       $id
     *
     * @return mixed
     */
    public function update(array $attributes, $id)
    {
        parent::update($attributes, $id);
    }
}