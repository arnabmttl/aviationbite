<?php

namespace App\Observers;

// Models
use App\Models\Favourite;

// Services
use App\Services\AuthService;
use App\Services\UserActionService;
use App\Services\ActivityService;

class FavouriteObserver
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
     * Handle the Favourite "created" event.
     *
     * @param  \App\Models\Favourite  $favourite
     * @return void
     */
    public function created(Favourite $favourite)
    {
        /**
         * Pass the currently logged in user to the user action and activity creation.
         */
        if($user = $this->authService->getCurrentlyLoggedInUser()) {
            $this->userActionService->createUserAction('created', $user, $favourite);
            $this->activityService->createActivity('created', $user, $favourite);
        }
    }

    /**
     * Handle the Favourite "updated" event.
     *
     * @param  \App\Models\Favourite  $favourite
     * @return void
     */
    public function updated(Favourite $favourite)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('updated', $user, $favourite);
    }

    /**
     * Handle the Favourite "deleted" event.
     *
     * @param  \App\Models\Favourite  $favourite
     * @return void
     */
    public function deleted(Favourite $favourite)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('deleted', $user, $favourite);

        /**
         * Delete corresponding activities as well.
         */
        $favourite->activities()->delete();
    }

    /**
     * Handle the Favourite "restored" event.
     *
     * @param  \App\Models\Favourite  $favourite
     * @return void
     */
    public function restored(Favourite $favourite)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('restored', $user, $favourite);
    }

    /**
     * Handle the Favourite "force deleted" event.
     *
     * @param  \App\Models\Favourite  $favourite
     * @return void
     */
    public function forceDeleted(Favourite $favourite)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('force-deleted', $user, $favourite);
    }
}
