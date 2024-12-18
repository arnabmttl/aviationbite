<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CeateThreadTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_an_authenticated_user_can_create_new_thread()
    {
        $this->actingAs(User::factory()->create());
        $thread = Thread::factory()->create();
        $this->post('/threads', $thread->toArray());
        $response = $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
