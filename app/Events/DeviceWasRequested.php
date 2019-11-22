<?php

namespace App\Events;

use App\DeviceSubscription;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeviceWasRequested
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var DeviceSubscription
     */
    public $deviceSubscription;

    /**
     * Create a new event instance.
     *
     * @param DeviceSubscription $deviceSubscription
     */
    public function __construct(DeviceSubscription $deviceSubscription)
    {
        $this->deviceSubscription = $deviceSubscription;
    }
}
