<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guest_can_register_himself()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->make();


        $this->post('/register', [
            'email' => $user->email,
            'name' => $user->name,
            'department_id' => $user->department_id,
            'password' => $user->password,
            'password_confirmation' => $user->password
        ]);

        $this->assertAuthenticated();

    }
}
