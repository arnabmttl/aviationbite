<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

// Services
use App\Services\UserActionService;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class CreateRegisteredAction
{
    /**
     * UserActionService instance to use various functions of UserActionService.
     *
     * @var \App\Services\UserActionService
     */
    protected $userActionService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->userActionService = new UserActionService;
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        if(!$this->userActionService->createUserAction('registered', $event->user))
            $this->failed($event, new Exception('Create registered action failed.', 1));
    }

    /**
     * Handle a job failure.
     *
     * @param  \App\Events\Registered  $event
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(Registered $event, $exception)
    {
        Log::channel('listener')->error("Create registered action failed.");
        Log::channel('listener')->error("User Id: ".$event->user->id);
        Log::channel('listener')->error($exception->getMessage());
    }
}
