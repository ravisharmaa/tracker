<?php

namespace App\Listeners;

use App\Mail\SubscriptionApproved;
use Illuminate\Support\Facades\Mail;

class NotifySubscriber
{
    /**
     * Handle the event.
     *
     * @param object $event
     */
    public function handle($event)
    {
        Mail::to('john@example.com')->send(new SubscriptionApproved($event->device, $event->approvedBy));
    }
}
