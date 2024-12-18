<?php

namespace App\Repositories;

// Model for the repository
use App\Models\User;

// Support Facades
use Illuminate\Support\Facades\Log;

// Eloquent Builder
use Illuminate\Database\Eloquent\Builder;

// Exception
use Exception;

class UserRepository extends BaseRepository
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
	 * Get the total number of users available.
	 *
	 * @return int|boolean
	 */
	public function getTotalUsers()
	{
		try {
			return User::count();
		} catch(Exception $e) {
			Log::channel('user')->error('[UserRepository:getTotalUsers] Total users not fetched because an exception occurred: ');
			Log::channel('user')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Create a new user.
	 *
	 * @param  array  $userDetails
	 * @return \App\Models\User|boolean
	 */
	public function createUser($userDetails)
	{
		try {
			return User::create($userDetails);
		} catch (Exception $e) {
			Log::channel('user')->error('[UserRepository:createUser] New user not created because an exception occurred: ');
			Log::channel('user')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get the first user by the referral code.
	 *
	 * @param  string  $referralCode
	 * @return \App\Models\User|boolean
	 */
	public function getFirstUserByReferralCode($referralCode)
	{
		try {
			return User::whereReferralCode($referralCode)->first();
		} catch (Exception $e) {
			Log::channel('user')->error('[UserRepository:getFirstUserByReferralCode] First user by referrral code not fetched because an exception occurred: ');
			Log::channel('user')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get the first user by the phone number.
	 *
	 * @param  string  $phoneNumber
	 * @return \App\Models\User|boolean
	 */
	public function getFirstUserByPhoneNumber($phoneNumber)
	{
		try {
			return User::wherePhoneNumber($phoneNumber)->first();
		} catch (Exception $e) {
			Log::channel('user')->error('[UserRepository:getFirstUserByPhoneNumber] First user by phone number not fetched because an exception occurred: ');
			Log::channel('user')->error($e->getMessage());

			return false;
		}
	}

	/**
     * Update user by object.
     *
     * @param  array  $update
     * @param  \App\Models\User  $user
     * @return boolean
     */
    public function updateUserByObject($update, $user)
    {
        try {
            return $user->update($update);
        } catch (Exception $e) {
            Log::channel('user')->error('[UserRepository:updateUserByObject] User not updated by object because an exception occured: ');
            Log::channel('user')->error($e->getMessage());

            return false;
        }
    }

    /**
	 * Get the paginated list of users.
	 *
	 * @param  int  $perPage
	 * @return \Illuminate\Pagination\LengthAwarePaginator|boolean
	 */
	public function getPaginatedListOfUsers($perPage)
	{
		try {
			return User::paginate($perPage);
		} catch (Exception $e) {
			Log::channel('user')->error('[UserRepository:getPaginatedListOfUsers] Paginated list of users at not fetched because an exception occurred: ');
			Log::channel('user')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get the paginated list of users based on the username.
	 *
	 * @param  string  $username
	 * @param  int  $perPage
	 * @return \Illuminate\Database\Eloquent\Collection|boolean
	 */
	public function getPaginatedListOfUsersByUsername($username, $perPage)
	{
		try {
			return User::where('username', 'like', '%'.$username.'%')
							 ->paginate($perPage);
		} catch (Exception $e) {
			Log::channel('user')->error('[UserRepository:getPaginatedListOfUsersByUsername] Paginated list of users not fetched by username because an exception occurred: ');
			Log::channel('user')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get the plucked list of active students by username and id.
	 *
	 * @return \Illuminate\Support\Collection|boolean
	 */
	public function getPluckedListOfActiveStudentsByUsernameAndId()
	{
		try {
			return User::whereHas('role', function(Builder $query) {
							$query->whereLabel('student');
						 })
						 ->whereNotNull('username')
						 ->whereIsBlocked(0)
						 ->pluck('username', 'id');
		} catch (Exception $e) {
			Log::channel('user')->error('[UserRepository:getPluckedListOfActiveStudentsByUsernameAndId] Plucked list of active students by username and id not fetched because an exception occurred: ');
			Log::channel('user')->error($e->getMessage());

			return false;
		}
	}
}