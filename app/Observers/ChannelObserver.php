<?php

namespace App\Observers;

// Models
use App\Models\Channel;

// Services
use App\Services\AuthService;
use App\Services\UserActionService;

class ChannelObserver
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
     * Create a new observer instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authService = new AuthService;
        $this->userActionService = new UserActionService;
    }

    /**
     * Handle the Channel "created" event.
     *
     * @param  \App\Models\Channel  $channel
     * @return void
     */
    public function created(Channel $channel)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('created', $user, $channel);
    }

    /**
     * Handle the Channel "updated" event.
     *
     * @param  \App\Models\Channel  $channel
     * @return void
     */
    public function updated(Channel $channel)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('updated', $user, $channel);
    }

    /**
     * Handle the Channel "deleted" event.
     *
     * @param  \App\Models\Channel  $channel
     * @return void
     */
    public function deleted(Channel $channel)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('deleted', $user, $channel);

        /**
         * Delete associated threads as well.
         */
        $channel->threads()->delete();
    }

    /**
     * Handle the Channel "restored" event.
     *
     * @param  \App\Models\Channel  $channel
     * @return void
     */
    public function restored(Channel $channel)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('restored', $user, $channel);
    }

    /**
     * Handle the Channel "force deleted" event.
     *
     * @param  \App\Models\Channel  $channel
     * @return void
     */
    public function forceDeleted(Channel $channel)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('force-deleted', $user, $channel);
    }
}
