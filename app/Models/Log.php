<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Log extends Model
{
    private static $events = [
        'clients.index'   => 'Просмотр списка клиентов',
        'clients.create'  => 'Создание клиента',
        'clients.store'   => 'Сохранение клиента',
        'clients.show'    => 'Просмотр клиента',
        'clients.edit'    => 'Просмотр клиента',
        'clients.update'  => 'Редактирование клиента',
        'clients.destroy' => 'Удаление клиента',
        'events.index'    => 'Просмотр списка мероприятий',
        'events.create'   => 'Создание мероприятия',
        'events.store'    => 'Сохранение мероприятия',
        'events.show'     => 'Просмотр мероприятия',
        'events.edit'     => 'Просмотр мероприятия',
        'events.update'   => 'Редактирование мероприятия',
        'events.word'     => 'Скачивание КП в Word',
        'events.xls'      => 'Скачивание КП в XLS',
        'events.pdf'      => 'Скачивание КП в PDF',
        'events.destroy'  => 'Удаление мероприятия',
        'calendar.index'  => 'Календарь мероприятий',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'event', 'element_id', 'element_name'
    ];

    public $table = 'logging';

    /**
     * Add event
     *
     * @param $user_id
     * @param $event
     * @param array $parameters
     *
     * @return boolean
     */
    public static function info($user_id, $event, array $parameters)
    {
        if ((string)$event == '') {
            return false;
        }

        $element_id = @array_pop($parameters);

        self::create(['user_id' => $user_id, 'event' => $event, 'element_id' => $element_id, 'element_name' => self::elementName($event, $element_id)]);

        return true;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function action(Request $request)
    {
        $action = @$request->route()->getAction()['as'];

        if ($action == 'events.update') {
            if ($request->exists('xls')) { $action = 'events.xls'; }
            if ($request->exists('word')) { $action = 'events.word'; }
            if ($request->exists('pdf')) { $action = 'events.pdf'; }
        }

        return $action;
    }

    /**
     * Get element name
     *
     * @param $event
     * @param $element_id
     * @return null
     */
    public static function elementName($event, $element_id)
    {
        if (preg_match('/^clients\./i', $event)) {
            try {
                return Client::find($element_id)->name;
            }catch (\Exception $e) {
                return '';
            }
        } elseif (preg_match('/^events\./i', $event)) {
            try {
                return Event::find($element_id)->name;
            }catch (\Exception $e) {
                return '';
            }
        } else {
            return null;
        }
    }

    public function getEventNameAttribute()
    {
        if (isset(self::$events[$this->attributes['event']])) {
            return self::$events[$this->attributes['event']];
        }

        return $this->attributes['event'];
    }

    public function getDateAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->setTimezone(config('app.timezone'))->format('d.m.Y H:i:s');
    }

    public static function getRandEvent()
    {
        return array_keys(self::$events)[rand(0, sizeof(self::$events)-1)];
    }
}