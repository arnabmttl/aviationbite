<?php

namespace App\Services;

// Repositories
use App\Repositories\UserActionRepository;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class UserActionService extends BaseService
{
	/**
	 * UserActionRepository instance to use various functions of UserActionRepository.
	 *
	 * @var \App\Repositories\UserActionRepository
	 */
	protected $userActionRepository;

	/**
	 * Create a new service instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->userActionRepository = new UserActionRepository;
	}

	/**
	 * Create a new user action based on the provided parameters. If the action is 
	 * 'logged-in' then save the 'ip_address' and 'user_agent' details in 'remarks' column.
	 *
	 * @param  string  $action
	 * @param  mixed  $user
	 * @param  mixed  $actionOn|null
	 * @param  string  $action|null
	 * @return \App\Models\UserAction|boolean
	 */
	public function createUserAction($action, $user, $actionOn = null)
	{
		
		try {
			$input['session_id'] = \Illuminate\Support\Facades\Session::getId();
			$input['action'] = $action;
			$input['actionable_id'] = $actionOn ? $actionOn->id : null;
			$input['actionable_type'] = $actionOn ? 'App\Models\\'.class_basename($actionOn) : null;

			if(($action == 'logged-in') || ($action == 'logged-out') || ($action == 'registered')) {
				$remarks['ip_address'] = request()->ip();
				$remarks['user_agent'] = request()->header('User-Agent');

				$input['remarks'] = json_encode($remarks);
			} else {
				$input['remarks'] = $actionOn ? $actionOn->toJson() : null;
			}
			
			return $this->userActionRepository->createUserAction($user, $input);
		} catch (Exception $e) {
            Log::channel('useraction')->error("[UserActionService:createUserAction] New user action not created because an exception occured: ");
            Log::channel('useraction')->error($e->getMessage());

            return false;
        }
	}
}