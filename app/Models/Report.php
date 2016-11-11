<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public static function lastVisit()
    {
        $staff = app('App\Repository\UserRepository');

        $users = [];

        foreach ($staff->findWhereIn('job', ['manager', 'cook']) as $user) {
            $date = null;
            if ($user->lastvisit_at !== null) {
                $date = Carbon::parse($user->lastvisit_at)->setTimezone(config('app.timezone'));
                if ($date->format('d.m.Y') != Carbon::now()->setTimezone(config('app.timezone'))->format('d.m.Y')) {
                    $date = null;
                }
            }
            $users[] = (object)[
                'name' => $user->full_name,
                'time' => $date != null ? $date->format('H:i') : 'Не входил'
            ];
        }

        return $users;
    }
}
