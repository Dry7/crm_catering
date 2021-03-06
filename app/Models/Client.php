<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'name', 'phone_work', 'phone_mobile', 'phone_other', 'phone_other2', 'fio', 'job', 'birthday', 'email', 'events', 'site',
        'address', 'description', 'hobby'
    ];

    /**
     * Dates
     *
     * @var array
     */
    protected $dates = [
        'birthday'
    ];

    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] = (string)$value != '' ? Carbon::createFromFormat('d.m.Y', $value) : null;
    }
}
