<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{
    //use RefreshDatabase;
    use DatabaseMigrations;
    public function setUp()
    {
        parent::setUp();
        this->$thread= Thread::factory()->create();
    }

    /** @test */
    public function test_a_user_can_view_all_threads()
    {
        $response = $this->get('/threads');
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function test_a_user_can_read_a_single_thread()
    {
        $response = $this->get($this->thread->path());
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function test_a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $reply = Reply::factory()->create(['thread_id' => $this->thread->id]);
        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function test_a_thread_has_a_creator()
    {
        $this->assertInstanceOf(''App\User', $thread->creator')
    }

    /** @test */
    public function test_a_thread_can_add_a_reply()
    {
        $this->thread->addReply([

        ]);
    }
}
