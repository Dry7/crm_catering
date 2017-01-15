<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'surname', 'name', 'patronymic', 'email', 'password', 'job', 'active', 'work_hours', 'lastvisit_at', 'photo'
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
     * Dates
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'lastvisit_at'
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
        if (App::getLocale() == 'en') {
            return 'Yours faithfully, ' . $this->getFullNameAttribute(false) . '<br />' .
            'Lead Project Manager<br />' .
            'Company «Fusion Service»<br />' .
            'Phone: +7 (812) 602 05 20<br />' .
            'e-mail: office@fusion-service.com<br />' .
            'КЕЙТЕРИНГ.РФ';
        } else {
            return 'С уважением, ' . $this->getFullNameAttribute(false) . '<br />' .
            'Ведущий менеджер проекта<br />' .
            'Компания «Fusion Service»<br />' .
            'Тел: +7 (812) 602 05 20<br />' .
            'e-mail: office@fusion-service.com<br />' .
            'КЕЙТЕРИНГ.РФ';
        }
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

    /**
     * Get admin emails
     *
     * @return array
     */
    public static function getAdminEmails()
    {
        return self::where('job', 'admin')->get()->map(function ($item) {
            return $item->email;
        })->toArray();
    }


    /**
     * Check photo exists
     * @return mixed
     */
    public function getPhotoHasAttribute()
    {
        return Storage::exists(@$this->attributes['photo']);
    }

    /**
     * Get photo url
     *
     * @return mixed
     */
    public function getPhotoUrlAttribute()
    {
        return Storage::url(@$this->attributes['photo']);
    }

    /**
     * Get base64 code of photo
     *
     * @return string
     */
    public function getPhotoBase64Attribute()
    {
        return 'data:image/jpeg;base64,' . base64_encode(Storage::get(@$this->attributes['photo']));
    }

    /**
     * Get image size
     *
     * @param integer $max_width
     *
     * @return object
     */
    public function getPhotoSizeAttribute($max_width = null)
    {
        $size = getimagesizefromstring(Storage::get(@$this->attributes['photo']));

        if ($max_width == null) {
            $width = $size[0];
            $height = $size[1];
        } else {
            $width = $max_width;
            $height = $size[1]/$size[0]*$width;
        }

        return (object)[
            'width' => $width,
            'height' => $height
        ];
    }

    /**
     * Delete photo
     *
     * @return mixed
     */
    public function photoDelete()
    {
        return Storage::delete(@$this->attributes['photo']);
    }
}
