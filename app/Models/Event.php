<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    private static $statuses = [
        1 => 'Черновик',
        2 => 'Выслано КП',
        3 => 'Утвержден',
        4 => 'В работе',
        5 => 'Отменен'
    ];

    private static $formats = [
        1 => 'Банкет',
        2 => 'Фуршет',
        3 => 'Кофе-брейк'
    ];

    private static $taxes = [
        1 => 'НДС входит в стоимость',
        2 => 'Стоимость без учета НДС +18%',
        3 => 'Стоимость без НДС'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'status_id', 'client_id', 'date', 'format_id', 'persons', 'tables',
        'place_id', 'staff', 'meeting', 'main', 'hot_snacks', 'sorbet', 'hot', 'dessert', 'sections',
        'weight_person', 'tax_id', 'discount', 'template'
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

    private function time($value)
    {
        return $value != '' ? Carbon::parse('01.01.2016 ' . $value)->format('H:i') : '';
    }

    public function getMeetingAttribute()
    {
        return $this->time(@$this->attributes['meeting']);
    }

    public function getMainAttribute()
    {
        return $this->time(@$this->attributes['main']);
    }

    public function getHotSnacksAttribute()
    {
        return $this->time(@$this->attributes['hot_snacks']);
    }

    public function getSorbetAttribute()
    {
        return $this->time(@$this->attributes['sorbet']);
    }

    public function getHotAttribute()
    {
        return $this->time(@$this->attributes['hot']);
    }

    public function getDessertAttribute()
    {
        return $this->time(@$this->attributes['dessert']);
    }

    public function getTaxAttribute()
    {
        return @self::$taxes[$this->attributes['tax_id']];
    }

    public function getStatuses()
    {
        return self::$statuses;
    }

    public function getFormats()
    {
        return self::$formats;
    }

    public function getTaxes()
    {
        return self::$taxes;
    }

    public function getTemplates()
    {
        return [
            'default' => 'default'
        ];
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = (string)$value != '' ? Carbon::createFromFormat('d.m.Y', $value) : null;
    }

    public function getSectionsListqsqsxcq()
    {
        return json_decode($this->sections);
    }

    public function getSectionsList($person = true)
    {
        $sections = json_decode($this->sections);

        for ($i = 0, $sizeof = sizeof($sections); $i < $sizeof; $i++) {
            if (!is_object($sections[$i]->category)) {
                $sections[$i]->category = (object)['code' => '', 'name' => '', 'section1' => '', 'section2' => '', 'section3' => '', 'section4' => ''];
            }
            $sections[$i]->category->total = 0;
            $sections[$i]->category->total_weight = 0;
            for ($j = 0, $sizeof2 = sizeof($sections[$i]->rows); $j < $sizeof2; $j++) {
                $sections[$i]->rows[$j]->total = @$sections[$i]->rows[$j]->product->price * $sections[$i]->rows[$j]->amount;
                $sections[$i]->rows[$j]->total_weight = @$sections[$i]->rows[$j]->product->weight * $sections[$i]->rows[$j]->amount;
                $sections[$i]->category->total += $sections[$i]->rows[$j]->total;
                $sections[$i]->category->total_weight = @$sections[$i]->rows[$j]->product->weight* $sections[$i]->rows[$j]->amount;
            }
        }

        return $sections;
    }

    /**
     * Total price
     *
     * @param boolean $person By person
     *
     * @return int
     */
    public function getTotal($person = false)
    {
        $total = 0;

        $sections = $this->getSectionsList();

        foreach ($sections as $section) {
            $total += $section->category->total;
        }

        return $person ? (int)($total/$this->persons) : $total;
    }

    /**
     * Name of event
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return implode(' - ', [
            @$this->client->name,
            @$this->place->name,
            @$this->date->format('d.m.Y')
        ]);
    }

    /**
     * Get color of event status
     *
     * @return string
     */
    public function getColorAttribute()
    {
        switch ($this->attributes['status_id']) {
            case 3:
                return '#ff0000';
                break;
            case 2:
            case 4:
                return '#0000ff';
                break;
            case 1:
            case 5:
            default:
                return '#808080';
        }
    }
}
