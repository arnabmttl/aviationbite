<?php

namespace App\Listeners;

use App\Events\UserLoggedOut;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

// Services
use App\Services\UserActionService;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class CreateLoggedOutAction
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
     * @param  UserLoggedOut  $event
     * @return void
     */
    public function handle(UserLoggedOut $event)
    {
        if(!$this->userActionService->createUserAction('logged-out', $event->user))
            $this->failed($event, new Exception('Create logged out action failed.', 1));
    }

    /**
     * Handle a job failure.
     *
     * @param  \App\Events\UserLoggedOut  $event
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(UserLoggedOut $event, $exception)
    {
        Log::channel('listener')->error("Create logged out action failed.");
        Log::channel('listener')->error("User Id: ".$event->user->id);
        Log::channel('listener')->error($exception->getMessage());
    }
}
