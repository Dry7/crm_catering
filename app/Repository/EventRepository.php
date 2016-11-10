<?php

namespace App\Repository;

use App\Criteria\UserIDCriteria;
use Illuminate\Support\Facades\Auth;

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
     * Save a new entity in repository
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes)
    {
        if (!Auth::user()->isAdmin()) {
            if ($attributes['discount'] > 10) {
                $attributes['discount'] = 10;
            }
        }
        return parent::create($attributes); // TODO: Change the autogenerated stub
    }

    /**
     * Update a entity in repository by id
     *
     * @param array $attributes
     * @param       $id
     *
     * @return mixed
     */
    public function update(array $attributes, $id)
    {
        if (!Auth::user()->isAdmin()) {
            if ($attributes['discount'] > 10) {
                $attributes['discount'] = 10;
            }
        }
        return parent::update($attributes, $id);
    }
}