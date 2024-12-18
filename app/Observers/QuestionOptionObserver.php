<?php

namespace App\Observers;

// Models
use App\Models\QuestionOption;

// Services
use App\Services\AuthService;
use App\Services\UserActionService;

class QuestionOptionObserver
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
     * Handle the QuestionOption "created" event.
     *
     * @param  \App\Models\QuestionOption  $questionOption
     * @return void
     */
    public function created(QuestionOption $questionOption)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if ($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('created', $user, $questionOption);
    }

    /**
     * Handle the QuestionOption "updated" event.
     *
     * @param  \App\Models\QuestionOption  $questionOption
     * @return void
     */
    public function updated(QuestionOption $questionOption)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if ($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('updated', $user, $questionOption);
    }

    /**
     * Handle the QuestionOption "deleted" event.
     *
     * @param  \App\Models\QuestionOption  $questionOption
     * @return void
     */
    public function deleted(QuestionOption $questionOption)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if ($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('deleted', $user, $questionOption);

        /**
         * Delete all the documents related to this option.
         */
        $questionOption->documents()->delete();
    }

    /**
     * Handle the QuestionOption "restored" event.
     *
     * @param  \App\Models\QuestionOption  $questionOption
     * @return void
     */
    public function restored(QuestionOption $questionOption)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if ($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('restored', $user, $questionOption);
    }

    /**
     * Handle the QuestionOption "force deleted" event.
     *
     * @param  \App\Models\QuestionOption  $questionOption
     * @return void
     */
    public function forceDeleted(QuestionOption $questionOption)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if ($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('force-deleted', $user, $questionOption);
    }
}
