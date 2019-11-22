<?php

namespace Tests\Feature;

use App\Device;
use App\DeviceSubscription;
use App\Events\DeviceWasRequested;
use App\Events\SubscriptionWasGranted;
use App\Listeners\NotifySubscriber;
use App\Listeners\SendNotificationEmail;
use App\Mail\RequestForwarded;
use App\Mail\SubscriptionApproved;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SubscribeToDeviceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guests_cannot_subscribe_device()
    {
        $this->withExceptionHandling();

        $device = factory(Device::class)->create();

        $this->postJson(route('subscriptions.store', ['device' => $device]))
            ->assertStatus(401);
    }

    /**
     * @test
     */
    public function authorised_user_can_ask_for_device_subscription()
    {
        $this->withExceptionHandling();

        $johnDoe = factory(User::class)->create();

        $deviceRelatedToJohnDoe = factory(Device::class)->create(['user_id' => $johnDoe->id]);

        $this->actingAs($johnDoe)->post(route('subscriptions.store', ['device' => $deviceRelatedToJohnDoe]));

        $this->assertSame(1, $deviceRelatedToJohnDoe->fresh()->subscriptions->count());
    }

    /**
     * @test
     */
    public function user_may_not_subscribe_un_authorized_devices()
    {
        $this->withExceptionHandling();

        $johnDoe = factory(User::class)->create();

        factory(Device::class)->create(['user_id' => $johnDoe->id]);

        $deviceNotRelatedToJohnDoe = factory(Device::class)->create();

        $this->actingAs($johnDoe)
            ->post(route('subscriptions.store', ['device' => $deviceNotRelatedToJohnDoe]))
            ->assertStatus(403);
    }

    /**
     * @test
     */
    public function device_can_be_subscribed_once()
    {
        Event::fake();

        $this->withExceptionHandling();

        $johnDoe = factory(User::class)->create();

        $device = factory(Device::class)->create([
            'user_id' => $johnDoe->id,
        ]);

        $this->actingAs($johnDoe)->post(route('subscriptions.store', ['device' => $device]));

        $this->assertDatabaseHas('device_subscriptions', [
            'user_id' => $johnDoe->id,
            'device_id' => $device->id,
            'requested_at' => now(),
        ]);

        $this->actingAs($johnDoe)->post(route('subscriptions.store', ['device' => $device]))
            ->assertStatus(403);
    }

    /**
     * @test
     */
    public function it_dispatches_event_on_subscription()
    {
        Event::fake();

        $user = factory(User::class)->create();

        $this->actingAs($user);

        $device = factory(Device::class)->create([
            'user_id' => $user->id,
        ]);

        $device->subscribe($user)->notify();

        $deviceSubscription = DeviceSubscription::first();

        Event::assertDispatched(DeviceWasRequested::class, function ($event) use ($deviceSubscription) {
            return $event->deviceSubscription->subscription_id === $deviceSubscription->subscription_id;
        });
    }

    /**
     * @test
     */
    public function it_notifies_the_concerned_when_asked_for_subscription()
    {
        Mail::fake();

        $deviceSubscription = factory(DeviceSubscription::class)->make([
            'user_id' => 123,
        ]);

        (new SendNotificationEmail())->handle(new DeviceWasRequested($deviceSubscription));

        Mail::assertSent(RequestForwarded::class, function ($mail) use ($deviceSubscription) {
            return $mail->deviceSubscription->subscription_id === $deviceSubscription->subscription_id;
        });
    }

    /**
     * @test
     */
    public function guests_can_grant_the_subscription()
    {
        $deviceSubscription = factory(DeviceSubscription::class)->create();

        $this->get(route('subscriptions.edit', ['deviceSubscription' => $deviceSubscription]))
        ->assertSee($deviceSubscription->device->name);
    }

    /**
     * @test
     */
    public function it_dispatches_event_for_approval()
    {
        Event::fake();

        $deviceSubscription = factory(DeviceSubscription::class)->create();

        $this->post(route('subscriptions.update', ['deviceSubscription' => $deviceSubscription]), [
            'approved_by' => 'johnDoe',
        ]);

        $this->assertSame('johnDoe', $deviceSubscription->fresh()->approved_by);

        Event::assertDispatched(SubscriptionWasGranted::class, function ($event) use ($deviceSubscription) {
            return $event->device->name === $deviceSubscription->device->name;
        });
    }

    /**
     * @test
     */
    public function it_notifies_the_concerned_for_approval()
    {
        Mail::fake();

        $deviceSubscription = factory(DeviceSubscription::class)->make([
            'user_id' => 123,
            'approved_at' => now(),
            'approved_by' => 'johnDoe',
        ]);

        (new NotifySubscriber())->handle(new SubscriptionWasGranted($deviceSubscription->device, 'janeDoe'));

        Mail::assertSent(SubscriptionApproved::class, function ($mail) use ($deviceSubscription) {
            return $mail->device->name === $deviceSubscription->device->name;
        });
    }

    /**
     * @test
     */
    public function authorised_user_can_revoke_subscriptions()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();

        $deviceSubscription = factory(DeviceSubscription::class)->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user)->delete(route('subscriptions.destroy', ['deviceSubscription' => $deviceSubscription]));

        $this->assertNull($deviceSubscription->fresh()->requested_at);
    }
}
