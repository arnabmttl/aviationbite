<?php

namespace App\Repositories;

// Model for this repository
use App\Models\Faq;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class FaqRepository extends BaseRepository
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
	 * Create a new faq.
	 *
	 * @param  array  $input
	 * @return \App\Models\Faq|boolean
	 */
	public function createFaq($input)
	{
		try {
			return Faq::create($input);
		} catch (Exception $e) {
			Log::channel('faq')->error('[FaqRepository:createFaq] New faq not created because an exception occurred: ');
			Log::channel('faq')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Delete the faq by object.
	 *
	 * @param  \App\Models\Faq  $faq
	 * @return boolean
	 */
	public function deleteFaqByObject($faq)
	{
		try {
			return $faq->delete();
		} catch (Exception $e) {
			Log::channel('faq')->error('[FaqRepository:deleteFaqByObject] Faq not deleted by object because an exception occurred: ');
			Log::channel('faq')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get paginated list of faqs.
	 *
	 * @param  int  $perPage
	 * @return \Illuminate\Pagination\LengthAwarePaginator|boolean
	 */
	public function getPaginatedListOfFaqsHavingFaqType($perPage)
	{
		try {
			return Faq::whereNotNull('faq_type_id')
						->paginate($perPage);
		} catch (Exception $e) {
			Log::channel('faq')->error('[FaqRepository:getPaginatedListOfFaqsHavingFaqType] Paginated list of faqs not fetched because an exception occurred: ');
			Log::channel('faq')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Update the faq by object.
	 *
	 * @param  array  $update
	 * @param  \App\Models\Faq  $faq
	 * @return boolean
	 */
	public function updateFaqByObject($update, $faq)
	{
		try {
			return $faq->update($update);
		} catch (Exception $e) {
			Log::channel('faq')->error('[FaqRepository:updateFaqByObject] Faq not updated by object because an exception occurred: ');
			Log::channel('faq')->error($e->getMessage());

			return false;
		}
	}
}