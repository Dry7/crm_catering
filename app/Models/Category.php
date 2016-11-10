<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $primaryKey = 'code';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'name', 'section1', 'section2', 'section3', 'section4'
    ];

    /**
     * Hide fields in json
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
