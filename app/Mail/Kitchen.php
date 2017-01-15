<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Kitchen extends Mailable
{
    use Queueable, SerializesModels;

    public $event;
    public $file;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($event, $file)
    {
        $this->event = $event;
        $this->file = $file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('catering.fusion@yandex.ru')
            ->subject($this->event->name)
            ->view('emails.kitchen')
            ->attach($this->file);
    }
}
