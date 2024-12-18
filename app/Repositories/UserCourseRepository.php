<?php

namespace App\Repositories;

// Model for the repository
use App\Models\UserCourse;

class UserCourseRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct()
	{
		parent::__construct();
	}

	/**
     * Create a new course for a user by object.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrderItem  $orderItem
     * @return \App\Models\UserPackage|boolean
     */
    public function createUserCourseByObject($user, $orderItem)
    {
        try {
            $newUserCourse = new UserCourse;
            $newUserCourse->course_id = $orderItem->course_id;
            $newUserCourse->invoice_id = $orderItem->order->invoice->id;
            $newUserCourse->order_item_id = $orderItem->id;
            $newUserCourse->start_from = $orderItem->start_date;
            $newUserCourse->end_on = $orderItem->course->valid_for ? (\Carbon\Carbon::create($orderItem->start_date)->addDays($orderItem->course->valid_for)) : null;

            /**
             * Mark the user course as upcoming if the start date is in future.
             */
            if(\Carbon\Carbon::create($orderItem->start_date)->gt(now()))
                $newUserPackage->status = 2;

            return $user->courses()->save($newUserCourse);
        } catch (Exception $e) {
            Log::channel('user')->critical("[UserCourseRepository:createUserCourseByObject] New user course not created by object because an exception occured: ");
            Log::channel('user')->critical($e->getMessage());;

            return false;
        }
    }
}