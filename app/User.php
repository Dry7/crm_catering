<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'surname', 'name', 'patronymic', 'email', 'password', 'job', 'active', 'work_hours'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @brief Return string label for job
     *
     * @return string
     */
    public function getJobLabelAttribute()
    {
        switch ($this->attributes['job']) {
            case 'admin': return 'Администратор'; break;
            case 'manager': return 'Менеджер'; break;
            case 'cook': return 'Повар'; break;
        }

        return '';
    }

    /**
     * @brief Full name
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        $name = [];

        if (@$this->attributes['surname']    != '') { $name[] = $this->attributes['surname'];    }
        if (@$this->attributes['name']       != '') { $name[] = $this->attributes['name'];       }
        if (@$this->attributes['patronymic'] != '') { $name[] = $this->attributes['patronymic']; }
        if (@$this->attributes['username']   != '') { $name[] = '(' . $this->attributes['username'] . ')'; }

        return implode(' ', $name);
    }

    public function isAdmin()
    {
        return $this->job === 'admin';
    }
}
