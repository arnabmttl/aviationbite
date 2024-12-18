<?php

namespace App\Observers;

// Models
use App\Models\Tax;

// Services
use App\Services\AuthService;
use App\Services\UserActionService;

class TaxObserver
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
     * Handle the Tax "created" event.
     *
     * @param  \App\Models\Tax  $tax
     * @return void
     */
    public function created(Tax $tax)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('created', $user, $tax);
    }

    /**
     * Handle the Tax "updated" event.
     *
     * @param  \App\Models\Tax  $tax
     * @return void
     */
    public function updated(Tax $tax)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('updated', $user, $tax);
    }

    /**
     * Handle the Tax "deleted" event.
     *
     * @param  \App\Models\Tax  $tax
     * @return void
     */
    public function deleted(Tax $tax)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('deleted', $user, $tax);
    }

    /**
     * Handle the Tax "restored" event.
     *
     * @param  \App\Models\Tax  $tax
     * @return void
     */
    public function restored(Tax $tax)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('restored', $user, $tax);
    }

    /**
     * Handle the Tax "force deleted" event.
     *
     * @param  \App\Models\Tax  $tax
     * @return void
     */
    public function forceDeleted(Tax $tax)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('force-deleted', $user, $tax);
    }
}
