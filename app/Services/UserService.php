<?php

namespace App\Services;

// Models
use App\Models\Image;

// Services
use App\Services\MiscService;

// Repositories
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserCourseRepository;
use App\Repositories\UserOtpRepository;

// Events
use App\Events\OtpGenerated;

// Support Facades
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

// Exception
use Exception;

class UserService extends BaseService
{
	/**
	 * RoleRepository instance to use various functions of the RoleRepository.
	 *
	 * @var \App\Repositories\RoleRepository
	 */
	protected $roleRepository;

	/**
	 * UserRepository instance to use various functions of UserRepository.
	 *
	 * @var \App\Repositories\UserRepository
	 */
	protected $userRepository;

	/**
	 * Create a new service instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->roleRepository = new RoleRepository;
		$this->userRepository = new UserRepository;
	}

	/**
	 * Create new user.
	 *
	 * @param  array  $userDetails
	 * @return \App\Models\User|boolean
	 */
	public function createUser($userDetails)
	{
		try {
			/**
	         * Fetch the role by type and append role_id to userDetails and remove type.
	         */
	        $role = $this->roleRepository->getFirstRoleByLabel($userDetails['type']);
	        $userDetails['role_id'] = $role->id;
	        unset($userDetails['type']);

	        /**
	         * Hash the password given by the user before saving in database.
	         */
	        $userDetails['password'] = Hash::make($userDetails['password']);

	        /**
	         * Generating Referral Code for the user.
	         */
	        do {
	            $userDetails['referral_code'] = (new MiscService)->generateAlphaNumericCode(6);
	        } while($this->userRepository->getFirstUserByReferralCode($userDetails['referral_code']));

	        /**
	         * IF user created successfully
	         * THEN create an OTP for the user as well.
	         */
	        if ($user = $this->userRepository->createUser($userDetails)) {
	        	$miscService = new MiscService;
	        	$userOtpRepository = new UserOtpRepository;

	        	/**
		         * Generate a new OTP.
		         */
		        $otp = $miscService->generateNumericCode(4);

		        /**
		         * Save user OTP in the table.
		         */
		        if ($userOtpRepository->createUserOtpByObject(['otp' => $otp], $user))
		        	event(new OtpGenerated($user));
	        }

	        return $user;
		} catch (Exception $e) {
			Log::channel('user')->error('[UserService:createUser] New user not created because an exception occurred: ');
			Log::channel('user')->error($e->getMessage());

			return false;
		}
	}

	/**
     * Create user course based on the invoice object.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return boolean
     */
    public function createUserCourseByInvoiceObject($invoice)
    {
    	try {
	        $result = true;
	        $userCourseRepository = new UserCourseRepository;
	        foreach ($invoice->order->items as $item) {
	            $result = $result && $userCourseRepository->createUserCourseByObject($invoice->user, $item);
	        }

	        return $result;
	    } catch (Exception $e) {
			Log::channel('user')->error('[UserService:createUserCourseByInvoiceObject] New user course not created by invoice object because an exception occurred: ');
			Log::channel('user')->error($e->getMessage());

			return false;
		}
    }

    /**
     * Check if the given number exists or not.
     * If number exists then send an OTP.
     * Else create user with the phone number and send OTP.
     *
     * @param  int  $phoneNumber
     * @return \App\Models\User|boolean
     */
    public function checkNumber($phoneNumber)
    {
    	try {
	        /**
	         * Check if user exists with the given phone number or not.
	         */
	        if (!($user = $this->userRepository->getFirstUserByPhoneNumber($phoneNumber))) {
	            $user = $this->createUser([
											'phone_number' => $phoneNumber,
											'password' => (new MiscService)->generateAlphaNumericCode(8),
											'type' => 'student'
							            ]);
	        }

	        if ($user) {
	        	if ($user->is_blocked)
	            	return $user;
	            else if ($this->sendOTPByObject($user))
	            	return $user;
	            else
	            	return false;
	        }
	        else
	            return false;
	    } catch (Exception $e) {
			Log::channel('user')->error('[UserService:checkNumber] Check number does not worked because an exception occurred: ');
			Log::channel('user')->error($e->getMessage());

			return false;
		}
    }

    /**
     * Send OTP for a user by object.
     *
     * @param  \App\Models\User $user
     * @return boolean
     */
    public function sendOTPByObject($user)
    {
    	try {
	        /**
	         * If the OTP generated less than 30 seconds ago then do not generate new one.
	         */
	        if ($user->otp && ($user->otp->updated_at->floatDiffInSeconds(now(), false) <= 30)) {
	            return true;
	        }

	        /**
	         * Make repository and service objects to be used later.
	         */
	        $userOtpRepository = new UserOtpRepository;
	        $miscService = new MiscService;

	        /**
	         * Generate a new OTP which does not exist in the table.
	         */
	        $otp = $miscService->generateNumericCode(4);

	        /**
	         * If user's otp exist then update it with new otp.
	         * Else create otp for the user.
	         */
	        if ($user->otp) {
	            $userOtpRepository->updateUserOtpByObject(['otp' => $otp], $user->otp);
	        } else {
	            $userOtpRepository->createUserOtpByObject(['otp' => $otp], $user);
	        }

	        /**
	         * Call the OTP Generated event
	         */
	        event(new OtpGenerated($user));

	        return true;
	    } catch (Exception $e) {
			Log::channel('user')->error('[UserService:sendOTPByObject] OTP not sent by object because an exception occurred: ');
			Log::channel('user')->error($e->getMessage());

			return false;
		}
    }

    /**
     * Verify OTP for the given phone number.
     *
     * @param  array  $input
     * @return boolean
     */
    public function verifyOTP($input)
    {
    	try {
	        /** 
	         * Fetch the user against the phone number and check the validity of otp.
	         */
	        if (($user = $this->userRepository->getFirstUserByPhoneNumber($input['phone_number'])) && $user->otp->otp == $input['otp'])
	            if ($user->otp->updated_at->floatDiffInMinutes(now(), false) <= 30)
	                return true;
	            else
	                return false;
	        else
	            return false;
	    } catch (Exception $e) {
			Log::channel('user')->error('[UserService:verifyOTP] OTP not verified because an exception occurred: ');
			Log::channel('user')->error($e->getMessage());

			return false;
		}
    }

    /**
     * Log in the user using user's phone number.
     *
     * @param  int  $phoneNumber
     * @return boolean
     */
    public function logUserInByPhoneNumber($phoneNumber)
    {
    	try {
	        if (($user = $this->userRepository->getFirstUserByPhoneNumber($phoneNumber))) {
	            (new AuthService)->loginUserByObject($user);
	            
	            return true;
	        } else {
	            return false;
	        }
	    } catch (Exception $e) {
			Log::channel('user')->error('[UserService:logUserInByPhoneNumber] User not logged in by phone number because an exception occurred: ');
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
    		/**
    		 * IF picture is coming in the update
    		 * THEN update the profile picture.
    		 */
    		if (isset($update['picture'])) {
    			/**
    			 * Remove previous profile picture.
    			 */
    			if ($user->profilePicture)
    				$user->profilePicture->delete();

    			/**
    			 * Save image in storage.
    			 */
    			$profilePicture = Storage::put('/public/profilepictures', $update['picture']);

    			/**
                 * Create new image and save it using the relationship.
                 */
                $newImage = new Image;
                $newImage->type = 'Profile Picture';
                $newImage->url = 'profilepictures/'.basename($profilePicture);
                $newImage->text = null;
                $newImage->redirection_url = null;
                $newImage->button_text = null;

                $user->profilePicture()->save($newImage);
    		}

    		/**
    		 * Make other_details key for the update.
    		 */
    		$update['other_details'] = [
    			'dob' => isset($update['dob']) ? $update['dob'] : null,
    			'gender' => isset($update['gender']) ? $update['gender'] : null,
    			'designation' => isset($update['designation']) ? $update['designation'] : null,
    			'address' => isset($update['address']) ? $update['address'] : null,
    			'goal' => isset($update['goal']) ? $update['goal'] : null,
    			'newsletter' => isset($update['newsletter']) ? $update['newsletter'] : null,
    		];
    		unset($update['dob'], $update['gender'], $update['designation'], $update['address'], $update['picture'], $update['goal'], $update['newsletter']);

	        return $this->userRepository->updateUserByObject($update, $user);
	    } catch (Exception $e) {
			Log::channel('user')->error('[UserService:updateUserByObject] User not updated by object because an exception occurred: ');
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
			return $this->userRepository->getFirstUserByPhoneNumber($phoneNumber);
		} catch (Exception $e) {
			Log::channel('user')->error('[UserRepository:getFirstUserByPhoneNumber] First user by phone number not fetched because an exception occurred: ');
			Log::channel('user')->error($e->getMessage());

			return false;
		}
	}
}