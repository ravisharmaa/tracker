<?php

namespace App\Events;

use App\Device;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubscriptionWasGranted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Device
     */
    public $device;

    /**
     * @var string
     */
    public $approvedBy;

    /**
     * Create a new event instance.
     *
     * @param Device $device
     * @param string $approvedBy
     */
    public function __construct(Device $device, $approvedBy)
    {
        $this->device = $device;
        $this->approvedBy = $approvedBy;
    }
}
