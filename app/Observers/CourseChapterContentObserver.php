<?php

namespace App\Observers;

// Models
use App\Models\CourseChapterContent;

// Services
use App\Services\AuthService;
use App\Services\UserActionService;

class CourseChapterContentObserver
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
     * Handle the CourseChapterContent "created" event.
     *
     * @param  \App\Models\CourseChapterContent  $courseChapterContent
     * @return void
     */
    public function created(CourseChapterContent $courseChapterContent)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if ($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('created', $user, $courseChapterContent);
    }

    /**
     * Handle the CourseChapter "updated" event.
     *
     * @param  \App\Models\CourseChapterContent  $courseChapterContent
     * @return void
     */
    public function updated(CourseChapterContent $courseChapterContent)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if ($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('updated', $user, $courseChapterContent);
    }

    /**
     * Handle the CourseChapterContent "deleted" event.
     *
     * @param  \App\Models\CourseChapterContent  $courseChapterContent
     * @return void
     */
    public function deleted(CourseChapterContent $courseChapterContent)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if ($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('deleted', $user, $courseChapterContent);
    }

    /**
     * Handle the CourseChapterContent "restored" event.
     *
     * @param  \App\Models\CourseChapterContent  $courseChapterContent
     * @return void
     */
    public function restored(CourseChapterContent $courseChapterContent)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if ($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('restored', $user, $courseChapterContent);
    }

    /**
     * Handle the CourseChapterContent "force deleted" event.
     *
     * @param  \App\Models\CourseChapterContent  $courseChapterContent
     * @return void
     */
    public function forceDeleted(CourseChapterContent $courseChapterContent)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if ($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('force-deleted', $user, $courseChapterContent);
    }
}
