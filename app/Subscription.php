<?php

namespace App;

use App\Events\SubscriptionProcessed;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'subscription_code';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approve()
    {
        $this->update([
            'approved_by' => $this->user->department->head,
            'approved_at' => now(),
        ]);

        return $this;
    }

    public function inform()
    {
        event(new SubscriptionProcessed($this));
    }

    public function reject()
    {
        $this->update([
           'requested_at' => null,
        ]);

        return $this;
    }

    public function revoke()
    {
        $this->update([
           'returned_at' => now(),
        ]);

        return $this;
    }
}
