<?php

namespace App\Repositories;

// Model for the repository
use App\Models\Activity;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class ActivityRepository extends BaseRepository
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
     * Creating a new activity.
     *
     * @param  \App\Models\User  $user
     * @param  array  $input
     * @return \App\Models\Activity|boolean
     */
    public function createActivity($user, $input)
    {
        try {
        	$newActivity = new Activity($input);

            return $user->activities()->save($newActivity);
        } catch (Exception $e) {
            Log::channel('activity')->error("[ActivityRepository:createActivity] New activity not created because an exception occured: ");
            Log::channel('activity')->error($e->getMessage());

            return false;
        }
    }
}