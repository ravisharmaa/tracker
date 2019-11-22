<?php

namespace App;

use App\Events\DeviceWasRequested;
use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Device extends Model
{
    public function getRouteKeyName()
    {
        return 'code';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(DeviceSubscription::class);
    }

    /**
     * Creates a new Subscription
     * @param User $user
     * @return $this
     */

    public function subscribe(?User $user = null)
    {
        $this->subscriptions()->create([
           'requested_at' => now(),
           'subscription_id' => Str::uuid(),
           'user_id' => ($user)? $user->id : auth()->user()->id
        ]);

        return $this;
    }

    /**
     * Notifies for the subscription.
     *
     * @return void
     */
    public function notify()
    {
        event(new DeviceWasRequested($this->subscriptions()->latest()->first()));
    }


}
