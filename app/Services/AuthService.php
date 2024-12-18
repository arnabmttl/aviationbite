<?php

namespace App\Services;

// Services
use App\Services\MiscService;

// Support Facades
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

// Exception
use Exception;

class AuthService extends BaseService
{
	/**
	 * Create a new service instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get role label of currently logged in user.
	 *
	 * @return string|boolean
	 */
	public function getRoleLabelOfCurrentlyLoggedInUser()
	{
		try {
			if($user = Auth::user()) {
				return $user->role->label;
			} else {
				Log::channel('authentication')->error('[AuthService:getRoleLabelOfCurrentlyLoggedInUser] Role label of the currently logged in user not fetched because an exception occurred: ');
				Log::channel('authentication')->error('No user is currently logged in.');

				return false;
			}
		} catch(Exception $e) {
			Log::channel('authentication')->error('[AuthService:getRoleLabelOfCurrentlyLoggedInUser] Role label of the currently logged in user not fetched because an exception occurred: ');
			Log::channel('authentication')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Log the user into the system by the User object provided.
	 *
	 * @param  \App\Models\User  $user
	 * @return void
	 */
	public function loginUserByObject($user)
	{
		try {
			Auth::login($user);

			/**
			 * Create new random password for the user to be used for logging out of other devices.
			 */
			$password = (new MiscService)->generateAlphaNumericCode(15);
	        $user->password = Hash::make($password);
	        $user->save();

			/**
			 * Log user out of other devices.
			 */
			Auth::logoutOtherDevices($password);
		} catch(Exception $e) {
			Log::channel('authentication')->error('[AuthService:loginUserByObject] User not logged in by object because an error occurred: ');
			Log::channel('authentication')->error($e->getMessage());
		}
	}

	/**
	 * Get currently logged in user.
	 *
	 * @return \App\Models\User|boolean
	 */
	public function getCurrentlyLoggedInUser()
	{
		try {
			if($user = Auth::user()) {
				return $user;
			} else {
				Log::channel('authentication')->error('[AuthService:getCurrentlyLoggedInUser] Currently logged in user not fetched because an exception occurred: ');
				Log::channel('authentication')->error('No user is currently logged in.');

				return false;
			}
		} catch (Exception $e) {
            Log::channel('authentication')->error('[AuthService:getCurrentlyLoggedInUser] Currently logged in user not fetched because an exception occurred: ');
            Log::channel('authentication')->error($e->getMessage());

            return false;
        }
	}

	/**
	 * Get id of the currently logged in user.
	 *
	 * @return int|boolean
	 */
	public function getIdOfCurrentlyLoggedInUser()
	{
		try {
			return Auth::id();
		} catch (Exception $e) {
            Log::channel('authentication')->error('[AuthService:getIdOfCurrentlyLoggedInUser] Get id of currently logged in user did not worked because an exception occured: ');
            Log::channel('authentication')->error($e->getMessage());

            return false;
        }
	}
}