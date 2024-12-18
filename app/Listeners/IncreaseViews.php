<?php

namespace App\Listeners;

use App\Events\ThreadViewed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class IncreaseViews
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ThreadViewed  $event
     * @return void
     */
    public function handle(ThreadViewed $event)
    {
        $event->thread->increment('views');
    }
}
