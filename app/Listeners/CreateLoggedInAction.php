<?php

namespace App\Listeners;

use App\Events\UserAuthenticated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

// Services
use App\Services\UserActionService;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class CreateLoggedInAction
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
     * @param  UserAuthenticated  $event
     * @return void
     */
    public function handle(UserAuthenticated $event)
    {
        if(!$this->userActionService->createUserAction('logged-in', $event->user))
            $this->failed($event, new Exception('Create logged in action failed.', 1));
    }

    /**
     * Handle a job failure.
     *
     * @param  \App\Events\UserAuthenticated  $event
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(UserAuthenticated $event, $exception)
    {
        Log::channel('listener')->error("Create logged in action failed.");
        Log::channel('listener')->error("User Id: ".$event->user->id);
        Log::channel('listener')->error($exception->getMessage());
    }
}
