<?php

namespace App\Observers;

// Models
use App\Models\CourseChapter;

// Services
use App\Services\AuthService;
use App\Services\UserActionService;

class CourseChapterObserver
{
    /**
     * AuthService instance to use various functions of AuthService.
     *
     * @var \App\Services\AuthService
     */
    protected $authService;

    /**
     * UserActionService instance to use various functions of AuthService.
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
     * Handle the CourseChapter "created" event.
     *
     * @param  \App\Models\CourseChapter  $courseChapter
     * @return void
     */
    public function created(CourseChapter $courseChapter)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if ($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('created', $user, $courseChapter);
    }

    /**
     * Handle the CourseChapter "updated" event.
     *
     * @param  \App\Models\CourseChapter  $courseChapter
     * @return void
     */
    public function updated(CourseChapter $courseChapter)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if ($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('updated', $user, $courseChapter);
    }

    /**
     * Handle the CourseChapter "deleted" event.
     *
     * @param  \App\Models\CourseChapter  $courseChapter
     * @return void
     */
    public function deleted(CourseChapter $courseChapter)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if ($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('deleted', $user, $courseChapter);
    }

    /**
     * Handle the CourseChapter "restored" event.
     *
     * @param  \App\Models\CourseChapter  $courseChapter
     * @return void
     */
    public function restored(CourseChapter $courseChapter)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if ($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('restored', $user, $courseChapter);
    }

    /**
     * Handle the CourseChapter "force deleted" event.
     *
     * @param  \App\Models\CourseChapter  $courseChapter
     * @return void
     */
    public function forceDeleted(CourseChapter $courseChapter)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if ($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('force-deleted', $user, $courseChapter);
    }
}
