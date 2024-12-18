<?php

namespace App\Services;

// Repositories
use App\Repositories\ActivityRepository;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class ActivityService extends BaseService
{
	/**
	 * ActivityRepository instance to use various functions of ActivityRepository.
	 *
	 * @var \App\Repositories\ActivityRepository
	 */
	protected $activityRepository;

	/**
	 * Create a new service instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->activityRepository = new ActivityRepository;
	}

	/**
	 * Create a new actvity based on the provided parameters.
	 *
	 * @param  string  $type
	 * @param  \App\Models\User  $user
	 * @param  mixed  $activityOn
	 * @return \App\Models\Activity|boolean
	 */
	public function createActivity($type, $user, $activityOn)
	{
		
		try {
			$input['type'] = $type.'_'.strtolower(class_basename($activityOn));
			$input['subjectable_id'] = $activityOn->id;
			$input['subjectable_type'] = get_class($activityOn);

			return $this->activityRepository->createActivity($user, $input);
		} catch (Exception $e) {
            Log::channel('activity')->error("[ActivityService:createActivity] New activity not created because an exception occured: ");
            Log::channel('activity')->error($e->getMessage());

            return false;
        }
	}
}