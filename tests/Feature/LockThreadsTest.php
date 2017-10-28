<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LockThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function non_admin_may_not_lock_thread()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->post(route('locked-threads.store', $thread))->assertStatus(403);

        $this->assertFalse(!! $thread->fresh()->locked);
    }

    /** @test */
    function admin_can_lock_threads()
    {
        $this->signIn(factory('App\User')->states('administrator')->create());

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->post(route('locked-threads.store', $thread));

        $this->assertTrue($thread->fresh()->locked, 'Failed asserting');
    }

     /** @test */
    function admin_can_unlock_threads()
    {
        $this->signIn(factory('App\User')->states('administrator')->create());

<<<<<<< HEAD
        $thread = create('App\Thread', ['user_id' => auth()->id(), 'locked' => true]);
=======
        $thread = create('App\Thread', ['user_id' => auth()->id(), 'locked' => false]);
>>>>>>> 54da545db4cb5b6f81a419812358494af42d83a5

        $this->delete(route('locked-threads.destroy', $thread));

        $this->assertFalse($thread->fresh()->locked, 'Failed asserting thread was unlocked');
    }

    /** @test */
    function once_locked_a_thread_may_not_receive_new_replies()
    {
        $this->signIn();

        $thread = create('App\Thread', ['locked' => true]);

        $this->post($thread->path() . '/replies', [
            'body' => 'toto',
            'user_id' => auth()->id()
        ])->assertStatus(422);
    }
}
