<?php

namespace App\Repositories;

// Model for this repository
use App\Models\DifficultyLevel;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class DifficultyLevelRepository extends BaseRepository
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
	 * Get the total number of difficulty levels available.
	 *
	 * @return int|boolean
	 */
	public function getTotalDifficultyLevels()
	{
		try {
			return DifficultyLevel::count();
		} catch (Exception $e) {
			Log::channel('question')->error('[DifficultyLevelRepository:getTotalDifficultyLevels] Total difficulty levels not fetched because an exception occurred: ');
			Log::channel('question')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Create a new difficulty level.
	 *
	 * @param  array  $difficultyLevelDetails
	 * @return \App\Models\DifficultyLevel|boolean
	 */
	public function createDifficultyLevel($difficultyLevelDetails)
	{
		try {
			return DifficultyLevel::create($difficultyLevelDetails);
		} catch (Exception $e) {
			Log::channel('question')->error('[DifficultyLevelRepository:createDifficultyLevel] New difficulty level not created because an exception occurred: ');
			Log::channel('question')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get the plucked list of difficulty levels by title and id.
	 *
	 * @return \Illuminate\Support\Collection|boolean
	 */
	public function getPluckedListOfDifficultyLevelsByTitleAndId()
	{
		try {
			return DifficultyLevel::pluck('title', 'id');
		} catch (Exception $e) {
			Log::channel('question')->error('[DifficultyLevelRepository:getPluckedListOfDifficultyLevelsByTitleAndId] Plucked list of difficulty levels by title and id not fetched because an exception occurred: ');
			Log::channel('question')->error($e->getMessage());

			return false;
		}
	}

	/**
     * Get the first difficulty level by the title.
     *
     * @param  string  $title
     * @return \App\Models\DifficultyLevel|boolean
     */
    public function getFirstDifficultyLevelByTitle($title)
    {
        try {
            return DifficultyLevel::whereTitle($title)->first();
        } catch (Exception $e) {
            Log::channel('question')->error('[DifficultyLevelRepository:getFirstDifficultyLevelByTitle] First difficulty level by title not fetched because an exception occured: ');
            Log::channel('question')->error($e->getMessage());

            return false;
        }
    }
}