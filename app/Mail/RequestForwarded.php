<?php

namespace App\Mail;

use App\DeviceSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestForwarded extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var DeviceSubscription
     */
    public $deviceSubscription;

    /**
     * Create a new message instance.
     *
     * @param DeviceSubscription $deviceSubscription
     */
    public function __construct(DeviceSubscription $deviceSubscription)
    {
        $this->deviceSubscription = $deviceSubscription;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.request-forwarded');
    }
}
