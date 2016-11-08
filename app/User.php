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
     * @param boolean $login
     *
     * @return string
     */
    public function getFullNameAttribute($login = true)
    {
        $name = [];

        if ((string)@$this->attributes['surname']    != '') { $name[] = $this->attributes['surname'];    }
        if ((string)@$this->attributes['name']       != '') { $name[] = $this->attributes['name'];       }
        if ((string)@$this->attributes['patronymic'] != '') { $name[] = $this->attributes['patronymic']; }
        if (($login !== false) and ((string)@$this->attributes['username'] != '')) { $name[] = '(' . $this->attributes['username'] . ')'; }

        return implode(' ', $name);
    }

    public function getCopyrightAttribute()
    {
        return 'С уважением, ' . $this->getFullNameAttribute(false) . '<br />' .
            'Ведущий менеджер проекта<br />' .
            'Компания «Fusion Service»<br />' .
            'Тел: +7 (812) 602 05 20<br />' .
            'e-mail: office@fusion-service.com<br />' .
            'КЕЙТЕРИНГ.РФ';
    }

    public function isAdmin()
    {
        return $this->job === 'admin';
    }

    /**
     * Get max discount
     * 
     * @return int
     */
    public function getMaxDiscountAttribute()
    {
        return $this->isAdmin() ? 100 : 10;
    }
}
