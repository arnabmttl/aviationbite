<?php

namespace App\Repositories;

// Model for the repository
use App\Models\UserAction;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class UserActionRepository extends BaseRepository
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
     * Creating a new user action.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return \App\Models\UserAction|boolean
     */
    public function createUserAction($user, $input)
    {
        try {
        	$newUserAction = new UserAction($input);

            return $user->actions()->save($newUserAction);
        } catch (Exception $e) {
            Log::channel('useraction')->error("[UserActionRepository:createUserAction] New user action not created because an exception occured: ");
            Log::channel('useraction')->error($e->getMessage());

            return false;
        }
    }
}