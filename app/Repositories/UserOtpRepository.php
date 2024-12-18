<?php

namespace App\Repositories;

// Model for this repository
use App\Models\UserOtp;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class UserOtpRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get the first userotp by the otp.
     *
     * @param  int  $otp
     * @return \App\Models\UserOtp|boolean
     */
    public function getFirstUserOtpByOtp($otp)
    {
        try {
            return UserOtp::where('otp', $otp)->first();
        } catch (Exception $e) {
            Log::channel('user')->error('[UserOtpRepository:getFirstUserOtpByOtp] User otp not fetched because an exception occured: ');
            Log::channel('user')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Create userotp by object.
     *
     * @param  array  $input
     * @param  \App\Models\User  $user
     * @return \App\Models\UserOtp|boolean
     */
    public function createUserOtpByObject($input, $user)
    {
        try {
            $newUserOtp = new UserOtp($input);

            return $user->otp()->save($newUserOtp);
        } catch (Exception $e) {
            Log::channel('user')->error('[UserOtpRepository:createUserOtpByObject] User otp not created by object because an exception occured: ');
            Log::channel('user')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Update userotp by object.
     *
     * @param  array  $update
     * @param  \App\Models\UserOtp  $userOtp
     * @return boolean
     */
    public function updateUserOtpByObject($update, $userOtp)
    {
        try {
            return $userOtp->update($update);
        } catch (Exception $e) {
            Log::channel('user')->error('[UserOtpRepository:updateUserOtpByObject] User otp not updated by object because an exception occured: ');
            Log::channel('user')->error($e->getMessage());

            return false;
        }
    }
}