<?php

namespace App\Listeners;

use App\Events\NotificationEvent;
use App\Mail\Notification;
use Illuminate\Support\Facades\Mail;
use App\Helpers\SettingsHelper;

class NotificationListener {
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        // .....
    }

    /**
     * Handle the event.
     *
     * @param  NotificationEvent  $event
     * @return void
     */
    public function handle(NotificationEvent $event) {
        Mail::to(SettingsHelper::getSetting('EMAIL_NOTIFY'))->send(new Notification($event->data));
    }
}
