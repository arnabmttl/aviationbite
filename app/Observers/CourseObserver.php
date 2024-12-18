<?php

namespace App\Observers;

// Models
use App\Models\Course;

// Services
use App\Services\AuthService;
use App\Services\UserActionService;

class CourseObserver
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
     * Handle the Course "created" event.
     *
     * @param  \App\Models\Course  $course
     * @return void
     */
    public function created(Course $course)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if ($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('created', $user, $course);
    }

    /**
     * Handle the Course "updated" event.
     *
     * @param  \App\Models\Course  $course
     * @return void
     */
    public function updated(Course $course)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if ($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('updated', $user, $course);
    }

    /**
     * Handle the Course "deleted" event.
     *
     * @param  \App\Models\Course  $course
     * @return void
     */
    public function deleted(Course $course)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if ($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('deleted', $user, $course);
    }

    /**
     * Handle the Course "restored" event.
     *
     * @param  \App\Models\Course  $course
     * @return void
     */
    public function restored(Course $course)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if ($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('restored', $user, $course);
    }

    /**
     * Handle the Course "force deleted" event.
     *
     * @param  \App\Models\Course  $course
     * @return void
     */
    public function forceDeleted(Course $course)
    {
        /**
         * Pass the currently logged in user to the user action creation.
         */
        if ($user = $this->authService->getCurrentlyLoggedInUser())
            $this->userActionService->createUserAction('force-deleted', $user, $course);
    }
}
