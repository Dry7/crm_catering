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
        'name', 'name_en', 'weight', 'price', 'photo', 'cost', 'markup'
    ];

    /**
     * Hide fields in json
     *
     * @var array
     */
    protected $hidden = [
        'source', 'name_en', 'created_at', 'updated_at', 'cost', 'markup', 'photo'
    ];

    public function kitchen()
    {
        return $this->belongsTo('App\Models\Kitchen');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Type');
    }

    /**
     * Check photo exists
     * @return mixed
     */
    public function getPhotoHasAttribute()
    {
        return Storage::exists($this->attributes['photo']);
    }

    /**
     * Get photo url
     *
     * @return mixed
     */
    public function getPhotoUrlAttribute()
    {
        return Storage::url($this->attributes['photo']);
    }

    /**
     * Delete photo
     *
     * @return mixed
     */
    public function photoDelete()
    {
        return Storage::delete($this->attributes['photo']);
    }

    /**
     * Get type by category
     *
     * @param $category
     * @return int|null
     */
    public function getType($category) {
        $category = trim($category);

        if (preg_match('/^01/i', $category))   { return 1; }
        if (preg_match('/^0201/i', $category)) { return 2; }
        if (preg_match('/^0202/i', $category)) { return 3; }
        if (preg_match('/^0203/i', $category)) { return 4; }
        if (preg_match('/^0204/i', $category)) { return 4; }
        if (preg_match('/^0205/i', $category)) { return 5; }
        if (preg_match('/^0206/i', $category)) { return 6; }
        if (preg_match('/^03/i', $category))   { return 7; }
        if (preg_match('/^04/i', $category))   { return 8; }

        return null;
    }

    /**
     * Return section id from group string
     *
     * @param $group
     * @param $y
     * @return int|null
     */
    public function getSection($group, $y) {
        $int = @$group{(($y-1)*2)} . @$group{(($y-1)*2+1)};
        $int = (int)$int;
        return $int > 0 ? $int : null;
    }
}
