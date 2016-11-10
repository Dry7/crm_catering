<?php

namespace App\Criteria;

use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class UserIDCriteria
 * @package namespace App\Criteria;
 */
class UserIDCriteria implements CriteriaInterface
{
    /**
     * If user not admin show only his elements
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if (is_object(Auth::user()) and Auth::user()->isAdmin()) {
            return $model;
        } else {
            return $model->where('user_id', '=', Auth::user()->id);
        }
    }
}
