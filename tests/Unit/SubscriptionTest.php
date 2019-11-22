<?php

namespace Tests\Unit;

use App\DeviceSubscription;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_belongs_to_device()
    {
        $subscription = factory(DeviceSubscription::class)->create();

        $this->assertInstanceOf(BelongsTo::class, $subscription->device());
    }

    /**
     * @test
     */

    public function it_belongs_to_user()
    {
        $subscription = factory(DeviceSubscription::class)->create();

        $this->assertInstanceOf(BelongsTo::class, $subscription->user());
    }

    /**
     * @test
     */

    public function it_has_an_unique_subscription_id()
    {
        $subscriptionOne = factory(DeviceSubscription::class)->create();
        $subscriptionTwo = factory(DeviceSubscription::class)->create();

        $this->assertNotEquals($subscriptionOne->subscription_id, $subscriptionTwo->subscription_id);
    }

    /**
     * @test
     */
    public function it_can_be_completed()
    {
        $deviceSubscription = factory(DeviceSubscription::class)->create();

        $this->assertNull($deviceSubscription->approved_at);

        $deviceSubscription->complete();

        $this->assertNotNull($deviceSubscription->fresh()->approved_at);
    }

    /**
     * @test
     */

    public function it_can_be_revoked()
    {
        $deviceSubscription = factory(DeviceSubscription::class)->create();

        $this->assertNotNull($deviceSubscription->requested_at);

        $deviceSubscription->revoke();

        $this->assertNull($deviceSubscription->fresh()->requested_at);
    }


}
