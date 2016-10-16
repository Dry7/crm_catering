<?php

namespace App\Models;

use App\Repository\KitchenRepository;
use App\Repository\TypeRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    public function kitchen()
    {
        return $this->belongsTo('App\Models\Kitchen');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Type');
    }

    public function getPhotoHasAttribute()
    {
        return Storage::exists($this->attributes['photo']);
    }

    public function getPhotoUrlAttribute()
    {
        return Storage::url($this->attributes['photo']);
    }

    public function photoDelete()
    {
        return Storage::delete($this->attributes['photo']);
    }
}
