<?php

namespace App\Services;

// Repositories
use App\Repositories\DiscountRepository;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class DiscountService extends BaseService
{
	/**
	 * DiscountRepository instance to use various functions of DiscountRepository.
	 *
	 * @var \App\Repositories\DiscountRepository
	 */
	protected $discountRepository;

	/**
	 * Create a new service instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->discountRepository = new DiscountRepository;
	}

	/**
	 * Create a new discount.
	 *
	 * @param  array  $input
	 * @return \App\Models\Discount|boolean
	 */
	public function createDiscount($input)
	{
		try {
            /**
             * Save the students in temporary variable for attaching with the discount after creation.
             * And unset the 'students' as that is not to be inserted in database.
             */
            $students = isset($input['students']) ? $input['students'] : NULL;
            unset($input['students']);

            /**
             * Save the courses in temporary variable for attaching with the discount after creation.
             * And unset the 'students' as that is not to be inserted in database.
             */
            $courses = isset($input['courses']) ? $input['courses'] : NULL;
            unset($input['courses']);

            /**
             * Update the valid till for availability till end of day.
             */
            $input['valid_till'] = $input['valid_till'] . ' 23:59:59';

            /**
             * If new discount is created succesfully then do the further processing 
             * else return false. 
             */
            if ($newDiscount = $this->discountRepository->createDiscount($input)) {
                /**
                 * Associate students (if any) with the newly created discount.
                 */
                if ($students)
	                $newDiscount->users()->attach(
	                	$students,
	                	[
	                		'created_at' => now(),
	                		'updated_at' => now()
	                	]
	                );

	            /**
                 * Associate courses (if any) with the newly created discount.
                 */
                if ($students)
	                $newDiscount->courses()->attach(
	                	$courses,
	                	[
	                		'created_at' => now(),
	                		'updated_at' => now()
	                	]
	                );

	            return $newDiscount;
            }
            else
                return false;
		} catch (Exception $e) {
			Log::channel('discount')->error('[DiscountService:createDiscount] Discount not created because an exception occurred: ');
			Log::channel('discount')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Update the discount by the object.
	 *
	 * @param  array  $update
	 * @param  \App\Models\Discount  $discount
	 * @return boolean
	 */
	public function updateDiscountByObject($update, $discount)
	{
		try {
            /**
             * Save the topics in temporary variable for attaching with the discount after creation.
             * And unset the 'students' and 'courses' as that is not to be inserted in database.
             */
            $students = $update['students'];
            $courses = $update['courses'];
            unset($update['students'], $update['courses']);

            /**
             * If discount is updated succesfully then do the further processing 
             * else return false. 
             */
            if ($this->discountRepository->updateDiscountByObject($update, $discount)) {
                /**
                 * Associate students (if any) with the discount.
                 */
                if ($students)
	                $discount->users()->attach(
	                	$students,
	                	[
	                		'created_at' => now(),
	                		'updated_at' => now()
	                	]
	                );

	            /**
                 * Associate courses (if any) with the discount.
                 */
                if ($students)
	                $discount->courses()->attach(
	                	$courses,
	                	[
	                		'created_at' => now(),
	                		'updated_at' => now()
	                	]
	                );

	            return true;
            }
            else
                return false;
		} catch (Exception $e) {
			Log::channel('discount')->error('[DiscountService:updateDiscountByObject] Discount not updated by object because an exception occurred: ');
			Log::channel('discount')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get the discount by discount_code, username and course_slug.
	 *
	 * @param  string  $discountCode
	 * @param  string  $username
	 * @param  string  $courseSlug
	 * @return boolean
	 */
	public function getDisountByDiscountCodeUsernameAndCourseSlug($discountCode, $username, $courseSlug)
	{
		try {
			/**
			 * Variable to hold the status validity of discount.
			 */
			$validDiscount = true;

			/**
			 * Fetch the valid discount for the given discount code.
			 */
            if ($discount = $this->discountRepository->getFirstValidDiscountBasedOnDiscountCode($discountCode)) {
            	/**
            	 * IF discount has users THEN check for the given username.
            	 */
            	if ($discount->users->count()) {
            		if (!$discount->users()->whereUsername($username)->count())
            			$validDiscount = false;
            	}

            	/**
            	 * IF discount has courses THEN check for the given course slug.
            	 */
            	if ($discount->courses->count()) {
            		if (!$discount->courses()->whereSlug($courseSlug)->count())
            			$validDiscount = false;
            	}

            	/**
            	 * IF the valid discount variable is true
            	 * THEN return the discount as it is a valid discount
            	 * ELSE return false.
            	 */
            	if ($validDiscount)
            		return $discount;
            	else
            		return false;
            }

            return false;
		} catch (Exception $e) {
			Log::channel('discount')->error('[DiscountService:getDisountByDiscountCodeUsernameAndCourseSlug] Discount not fetched by discount code, username and course slug because an exception occurred: ');
			Log::channel('discount')->error($e->getMessage());

			return false;
		}
	}
}