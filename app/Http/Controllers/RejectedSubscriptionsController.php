<?php

namespace App\Http\Controllers;

use App\Subscription;

class RejectedSubscriptionsController extends Controller
{
    public function update(Subscription $subscription)
    {
        $subscription->reject()->inform();
    }
}
