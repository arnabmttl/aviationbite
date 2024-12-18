<?php

namespace App\Repositories;

// Model for the repository
use App\Models\Discount;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class DiscountRepository extends BaseRepository
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
	 * Get the paginated list of discounts ordered by updated at.
	 *
	 * @param  int  $perPage
	 * @return \Illuminate\Pagination\LengthAwarePaginator|boolean
	 */
	public function getPaginatedListOfDiscountsOrderedByUpdatedAt($perPage)
	{
		try {
			return Discount::orderBy('updated_at', 'desc')->paginate($perPage);
		} catch (Exception $e) {
			Log::channel('discount')->error('[DiscountRepository:getPaginatedListOfDiscountsOrderedByUpdatedAt] Paginated list of discounts ordered by updated at not fetched because an exception occurred: ');
			Log::channel('discount')->error($e->getMessage());

			return false;
		}
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
			return Discount::create($input);
		} catch (Exception $e) {
			Log::channel('discount')->error('[DiscountRepository:createDiscount] New discount not created because an exception occurred: ');
			Log::channel('discount')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Delete the discount by the object.
	 *
	 * @param  \App\Models\Discount  $discount
	 * @return boolean
	 */
	public function deleteDiscountByObject($discount)
	{
		try {
			return $discount->delete();
		} catch (Exception $e) {
			Log::channel('discount')->error('[DiscountRepository:deleteDiscountByObject] Discount not deleted by object because an exception occurred: ');
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
			return $discount->update($update);
		} catch (Exception $e) {
			Log::channel('discount')->error('[DiscountRepository:updateDiscountByObject] Discount not updated by object because an exception occurred: ');
			Log::channel('discount')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get first valid discount based on the discount code.
	 *
	 * @param  string  $discountCode
	 * @return boolean
	 */
	public function getFirstValidDiscountBasedOnDiscountCode($discountCode)
	{
		try {
			return Discount::whereCode($discountCode)
							 ->where('valid_from', '<', now())
							 ->where('valid_till', '>', now())
							 ->first();
		} catch (Exception $e) {
			Log::channel('discount')->error('[DiscountRepository:getFirstValidDiscountBasedOnDiscountCode] First valid discount not fetched based on discount code because an exception occurred: ');
			Log::channel('discount')->error($e->getMessage());

			return false;
		}
	}
}