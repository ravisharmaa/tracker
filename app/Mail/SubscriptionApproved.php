<?php

namespace App\Mail;

use App\Device;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionApproved extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Device
     */
    public $device;
    /**
     * @var string
     */
    public $approvedBy;

    /**
     * Create a new message instance.
     *
     * @param Device $device
     * @param string $approvedBy
     */
    public function __construct(Device $device, string $approvedBy)
    {
        $this->device = $device;
        $this->approvedBy = $approvedBy;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.subscription-approved');
    }
}
