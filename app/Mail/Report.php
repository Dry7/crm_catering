<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Report extends Mailable
{
    use Queueable, SerializesModels;

    private $staff;

    /**
     * Create a new message instance.
     */
    public function __construct($staff)
    {
        $this->staff = $staff;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $date = Carbon::now()->setTimezone(config('app.timezone'))->format('d.m.Y');
        return $this->from('catering.fusion@yandex.ru')
                    ->subject('Время захода сотрудников в CRM ' . $date)
                    ->view('emails.report')
                    ->with('staff', $this->staff)
                    ->with('date', $date);
    }
}
