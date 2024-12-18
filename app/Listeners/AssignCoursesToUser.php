<?php

namespace App\Listeners;

use App\Events\InvoiceCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

// Services
use App\Services\UserService;

// Exception
use Exception;

class AssignCoursesToUser
{
    /**
     * UserService instance to use various functions of the UserService.
     *
     * @var \App\Services\UserService
     */
    protected $userService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->userService = new UserService;
    }

    /**
     * Handle the event.
     *
     * @param  InvoiceCreated  $event
     * @return void
     */
    public function handle(InvoiceCreated $event)
    {
        if(!$this->userService->createUserCourseByInvoiceObject($event->invoice))
            $this->failed($event, new Exception('Allocation of user courses by invoice object failed.', 1));
    }

    /**
     * Handle a job failure.
     *
     * @param  \App\Events\InvoiceCreated  $event
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(InvoiceCreated $event, $exception)
    {
        Log::channel('listener')->error("[AssignCoursesToUser] Allocation of user courses by invoice model failed because an exception occured: ");
        Log::channel('listener')->error("[AssignCoursesToUser] Invoice Id: ".$event->invoice->id);
        Log::channel('listener')->error($exception->getMessage());
    }
}
