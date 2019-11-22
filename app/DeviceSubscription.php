<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceSubscription extends Model
{
    protected $guarded = [];

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'subscription_id';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function complete()
    {
        $this->update([
            'approved_at' => now(),
            'approved_by' => request('approved_by'),
        ]);

        return $this;
    }

    public function revoke()
    {
        $this->update([
           'requested_at' => null,
        ]);

        return $this;
    }
}
