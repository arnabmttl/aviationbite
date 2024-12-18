<?php

namespace App\Observers;

// Models
use App\Models\Thread;

// Services
use App\Services\AuthService;
use App\Services\UserActionService;
use App\Services\ActivityService;

class ThreadObserver
{
    /**
     * AuthService instance to use various functions of AuthService.
     *
     * @var \App\Services\AuthService
     */
    protected $authService;

    /**
     * UserActionService instance to use various functions of UserActionService.
     *
     * @var \App\Services\UserActionService
     */
    protected $userActionService;

    /**
     * ActivityService instance to use various functions of ActivityService.
     *
     * @var \App\Services\ActivityService
     */
    protected $activityService;

    /**
     * Create a new observer instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authService = new AuthService;
        $this->userActionService = new UserActionService;
        $this->activityService = new ActivityService;
    }

    /**
     * Handle the Thread "created" event.
     *
     * @param  \App\Models\Thread  $thread
     * @return void
     */
    public function created(Thread $thread)
    {
        /**
         * Pass the currently logged in user to the user action and activity creation.
         */
        if($user = $this->authService->getCurrentlyLoggedInUser()) {
            $this->userActionService->createUserAction('created', $user, $thread);
            $this->activityService->createActivity('created', $user, $thread);
        }
    }

    /**
     * Handle the Thread "updated" event.
     *
     * @param  \App\Models\Thread  $thread
     * @return void
     */
    public function updated(Thread $thread)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('updated', $user, $thread);
    }

    /**
     * Handle the Thread "deleted" event.
     *
     * @param  \App\Models\Thread  $thread
     * @return void
     */
    public function deleted(Thread $thread)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('deleted', $user, $thread);

        /**
         * Delete corresponding activities as well.
         */
        $thread->activities()->delete();
    }

    /**
     * Handle the Thread "restored" event.
     *
     * @param  \App\Models\Thread  $thread
     * @return void
     */
    public function restored(Thread $thread)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('restored', $user, $thread);
    }

    /**
     * Handle the Thread "force deleted" event.
     *
     * @param  \App\Models\Thread  $thread
     * @return void
     */
    public function forceDeleted(Thread $thread)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('force-deleted', $user, $thread);
    }
}
