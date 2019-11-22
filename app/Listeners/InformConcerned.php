<?php

namespace App\Listeners;

use App\Mail\SubscriptionCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class InformConcerned
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Mail::to($event->subscription->user->email)->send(new SubscriptionCompleted($event->subscription));
    }
}
