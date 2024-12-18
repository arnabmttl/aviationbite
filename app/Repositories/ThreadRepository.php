<?php

namespace App\Repositories;

// Model for the repository
use App\Models\Thread;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class ThreadRepository extends BaseRepository
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
	 * Get provided number of latest updated threads.
	 *
	 * @param  int  $numberOfThreads
	 * @return \Illuminate\Database\Eloquent\Collection|boolean
	 */
	public function getLatestUpdatedThreads($numberOfThreads)
	{
		try {
			return Thread::orderBy('updated_at', 'desc')->take($numberOfThreads)->get();
		} catch (Exception $e) {
			Log::channel('thread')->error('[ThreadRepository:getLatestUpdatedThreads] Provided number of latest updated threads not fetched because an exception occurred: ');
			Log::channel('thread')->error($e->getMessage());

			return false;
		}
	}
}