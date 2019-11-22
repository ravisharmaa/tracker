<?php

namespace App\Listeners;

use App\Mail\SubscriptionPrepared;
use Illuminate\Support\Facades\Mail;

class ProcessSubscription
{
    /**
     * Handle the event.
     *
     * @param object $event
     *
     * @return void
     */
    public function handle($event)
    {
        Mail::to(auth()->user()->department->head)->send(new SubscriptionPrepared($event->subscription));
    }
}
