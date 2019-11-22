<?php

namespace Tests\Feature;

use App\Department;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateDepartmentsTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function guests_cannot_create_departments()
    {
        $this->withExceptionHandling();
        $this->post(route('departments.store'))->assertRedirect('login');
    }

    /**
     * @test
     */
    public function super_user_can_create_departments()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'satya.maharjan@javra.com'
        ]);

        $department = factory(Department::class)->make();

        $this->actingAs($user)->postJson(route('departments.store'), $department->toArray());

        $this->assertDatabaseHas('departments', $department->toArray());

        $this->withExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'random.user@javra.com'
        ]);

        $department = factory(Department::class)->make();

        $this->actingAs($user)
            ->postJson(route('departments.store'), $department->toArray())
            ->assertStatus(401);

    }
}
