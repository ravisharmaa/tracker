<?php

namespace App\Listeners;

use App\Mail\RequestForwarded;
use Illuminate\Support\Facades\Mail;

class SendNotificationEmail
{
    /**
     * Handle the event.
     *
     * @param object $event
     */
    public function handle($event)
    {
        Mail::to('john@example.com')->send(new RequestForwarded($event->deviceSubscription));
    }
}
