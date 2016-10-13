<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'source', 'section1', 'section2', 'section3', 'section4', 'kitchen_id', 'type_id',
        'name', 'name_en', 'weight', 'price', 'photo'
    ];

    public function getKitchenAttribute()
    {
        switch ($this->attributes['kitchen_id']) {
            case 1: return 'Японская'; break;
            case 2: return 'Русская'; break;
            case 3: return 'Итальянская'; break;
        }
        return '';
    }

    public function getTypeAttribute()
    {
        switch ($this->attributes['kitchen_id']) {
            case 1: return 'Закуска'; break;
            case 2: return 'Основное'; break;
            case 3: return 'Десерт'; break;
            case 4: return 'Напитки'; break;
        }
        return '';
    }
}
