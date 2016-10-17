<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    private static $statuses = [
        1 => 'Черновик',
        2 => 'Выслано КП',
        3 => 'Утвержден',
        4 => 'В работе'
    ];

    private static $formats = [
        1 => 'Банкет',
        2 => 'Фуршет',
        3 => 'Кофе-брейк'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'status_id', 'client_id', 'date', 'format_id', 'persons', 'tables',
        'place_id', 'staff', 'meeting', 'main', 'hot_snacks', 'sorbet', 'hot', 'dessert'
    ];

    /**
     * Dates
     *
     * @var array
     */
    protected $dates = [
        'date'
    ];

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function place()
    {
        return $this->belongsTo('App\Models\Place');
    }

    public function getStatusAttribute()
    {
        return @self::$statuses[$this->attributes['status_id']];
    }

    public function getFormatAttribute()
    {
        return @self::$formats[$this->attributes['format_id']];
    }

    public function getStatuses()
    {
        return self::$statuses;
    }

    public function getFormats()
    {
        return self::$formats;
    }
}
