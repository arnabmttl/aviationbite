<?php

namespace App\Observers;

// Models
use App\Models\Reply;

// Services
use App\Services\AuthService;
use App\Services\UserActionService;
use App\Services\ActivityService;

class ReplyObserver
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
     * Handle the Reply "created" event.
     *
     * @param  \App\Models\Reply  $reply
     * @return void
     */
    public function created(Reply $reply)
    {
        /**
         * Pass the currently logged in user to the user action and activity creation.
         */
        if($user = $this->authService->getCurrentlyLoggedInUser()) {
            $this->userActionService->createUserAction('created', $user, $reply);
            $this->activityService->createActivity('created', $user, $reply);
        }
    }

    /**
     * Handle the Reply "updated" event.
     *
     * @param  \App\Models\Reply  $reply
     * @return void
     */
    public function updated(Reply $reply)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('updated', $user, $reply);
    }

    /**
     * Handle the Reply "deleted" event.
     *
     * @param  \App\Models\Reply  $reply
     * @return void
     */
    public function deleted(Reply $reply)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('deleted', $user, $reply);

        /**
         * Delete corresponding favourites as well.
         */
        $reply->favourites()->get()->each->delete();

        /**
         * Delete corresponding activities as well.
         */
        $reply->activities()->delete();
    }

    /**
     * Handle the Reply "restored" event.
     *
     * @param  \App\Models\Reply  $reply
     * @return void
     */
    public function restored(Reply $reply)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('restored', $user, $reply);
    }

    /**
     * Handle the Reply "force deleted" event.
     *
     * @param  \App\Models\Reply  $reply
     * @return void
     */
    public function forceDeleted(Reply $reply)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('force-deleted', $user, $reply);
    }
}
