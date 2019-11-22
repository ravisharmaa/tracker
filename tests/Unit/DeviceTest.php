<?php

namespace Tests\Unit;

use App\Device;
use App\DeviceSubscription;
use App\Events\DeviceWasRequested;
use App\Listeners\SendNotificationEmail;
use App\Mail\RequestForwarded;
use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class DeviceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_belongs_to_user()
    {
        $device = factory(Device::class)->create();

        $this->assertInstanceOf(BelongsTo::class, $device->user());
    }

    /**
     * @test
     */
    public function it_has_many_subscriptions()
    {
        $device = factory(Device::class)->create();

        $this->assertInstanceOf(HasMany::class, $device->subscriptions());
    }

    /**
     * @test
     */
    public function it_can_be_subscribed()
    {
        $user = factory(User::class)->create();

        $device = factory(Device::class)->create([
            'user_id' => $user->id,
        ]);

        $device->subscribe($user);

        $this->assertSame(1, $device->subscriptions()->count());
    }
}
