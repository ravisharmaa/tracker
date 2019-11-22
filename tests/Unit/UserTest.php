<?php

namespace Tests\Unit;

use App\Subscription;
use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_has_many_devices()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(HasMany::class, $user->devices());
    }

    /**
     * @test
     */

    public function it_belongs_to_a_department()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(BelongsTo::class, $user->department());
    }

    /**
     * @test
     */

    public function it_can_subscribe_an_item()
    {

        $user = factory(User::class)->create();

        $this->assertEmpty($user->fresh()->subscriptions);

        $user->subscribe($itemId = 1, $itemCode = 'some-random-code');

        $this->assertSame(1, $user->subscriptions()->count());
    }
}
