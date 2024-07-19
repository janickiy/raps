<?php

namespace App\Mail;

use App\Models\SettingsHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

class Notification extends Mailable implements ShouldQueue
{
    use Queueable;

    /**
     * The data.
     *
     * @var array
     */
    public $filename;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->from(env('MAIL_FROM_ADDRESS'), SettingsHelper::getSetting('SITE_NAME'))
            ->subject('Заявка на расчет проекта')
            ->attach($this->filename)
            ->view('notifications.send_application');
    }

}
