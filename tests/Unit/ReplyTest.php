<?php

namespace Tests\Unit;

use App\Models\Reply;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;
    /** @test  */
    public function test_has_an_owner()
    {
        $reply = Reply::factory()->create();
        $this->assertInstanceOf('App\User', $reply->owner);
    }
}
