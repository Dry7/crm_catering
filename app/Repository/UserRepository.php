<?php
/**
 * Created by PhpStorm.
 * User: Третьяков
 * Date: 08.10.2016
 * Time: 21:47
 */

namespace App\Repository;


class UserRepository extends BaseRepository
{
    function model()
    {
        return 'App\\User';
    }
}