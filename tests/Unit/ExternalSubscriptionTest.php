<?php

namespace Tests\Unit;

use App\Subscription;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExternalSubscriptionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_belongs_to_a_user()
    {
        $subscription = factory(Subscription::class)->create();

        $this->assertInstanceOf(BelongsTo::class, $subscription->user());
    }

    /**
     * @test
     */
    public function it_can_be_approved()
    {
        $subscription = factory(Subscription::class)->create();

        $this->assertNull($subscription->approved_at);

        $subscription->approve();

        $this->assertNotNull($subscription->fresh()->approved_at);
    }

    /**
     * @test
     */
    public function it_can_be_revoked()
    {
        $subscription = factory(Subscription::class)->create([
            'requested_at' => now()
        ]);

        $subscription->revoke();

        $this->assertNotNull($subscription->fresh()->returned_at);
    }

    /**
     * @test
     */
    public function it_can_be_rejected()
    {
        $subscription = factory(Subscription::class)->create([
            'requested_at' => now()
        ]);

        $this->assertNotNull($subscription->requested_at);

        $subscription->reject();

        $this->assertNull($subscription->requested_at);
    }
}
