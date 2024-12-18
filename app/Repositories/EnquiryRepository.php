<?php

namespace App\Repositories;

// Model for the repository
use App\Models\Enquiry;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class EnquiryRepository extends BaseRepository
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
	 * Get the paginated list of enquiries ordered by updated at.
	 *
	 * @param  int  $perPage
	 * @return \Illuminate\Pagination\LengthAwarePaginator|boolean
	 */
	public function getPaginatedListOfEnquiriesOrderedByUpdatedAt($perPage)
	{
		try {
			return Enquiry::orderBy('updated_at', 'desc')->paginate($perPage);
		} catch (Exception $e) {
			Log::channel('enquiry')->error('[EnquiryRepository:getPaginatedListOfEnquiriesOrderedByUpdatedAt] Paginated list of enquiries ordered by updated at not fetched because an exception occurred: ');
			Log::channel('enquiry')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Create a new enquiry.
	 *
	 * @param  array  $input
	 * @return \App\Models\Enquiry|boolean
	 */
	public function createEnquiry($input)
	{
		try {
			return Enquiry::create($input);
		} catch (Exception $e) {
			Log::channel('enquiry')->error('[EnquiryRepository:createEnquiry] New enquiry not created because an exception occurred: ');
			Log::channel('enquiry')->error($e->getMessage());

			return false;
		}
	}
}