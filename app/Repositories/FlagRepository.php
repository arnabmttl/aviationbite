<?php

namespace App\Repositories;

// Model for the repository
use App\Models\Flag;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class FlagRepository extends BaseRepository
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
	 * Get the paginated list of flags ordered by updated at.
	 *
	 * @param  int  $perPage
	 * @return \Illuminate\Pagination\LengthAwarePaginator|boolean
	 */
	public function getPaginatedListOfFlagsOrderedByUpdatedAt($perPage)
	{
		try {
			return Flag::orderBy('updated_at', 'desc')->paginate($perPage);
		} catch (Exception $e) {
			Log::channel('flag')->error('[FlagRepository:getPaginatedListOfFlagsOrderedByUpdatedAt] Paginated list of flags ordered by updated at not fetched because an exception occurred: ');
			Log::channel('flag')->error($e->getMessage());

			return false;
		}
	}
}