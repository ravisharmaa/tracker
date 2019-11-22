<?php

namespace Tests\Feature;

use Tests\TestCase;

class ViewHomeScreenTest extends TestCase
{
    /**
     * @test
     */
    public function guests_cannot_view_home_screen()
    {
        $this->get('/')->assertRedirect('/login');
    }
}
