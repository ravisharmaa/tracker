<?php

namespace Tests\Unit;

use App\Department;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DepartmentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */

    public function it_has_many_users()
    {
        $department = factory(Department::class)->create();

        $this->assertInstanceOf(HasMany::class, $department->users());
    }
}
