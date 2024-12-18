<?php

namespace App\Repositories;

// Model for this repository
use App\Models\Role;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class RoleRepository extends BaseRepository
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
	 * Get the total number of roles available.
	 *
	 * @return int|boolean
	 */
	public function getTotalRoles()
	{
		try {
			return Role::count();
		} catch(Exception $e) {
			Log::channel('role')->error('[RoleRepository:getTotalRoles] Total roles not fetched because an exception occurred: ');
			Log::channel('role')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Create a new role.
	 *
	 * @param  array  $roleDetails
	 * @return \App\Models\Role|boolean
	 */
	public function createRole($roleDetails)
	{
		try {
			return Role::create($roleDetails);
		} catch (Exception $e) {
			Log::channel('role')->error('[RoleRepository:createRole] New role not created because an exception occurred: ');
			Log::channel('role')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get the role based on the provided label.
	 *
	 * @param  string  $roleLabel
	 * @return \App\Models\Role|boolean
	 */
	public function getFirstRoleByLabel($roleLabel)
	{
		try {
			return Role::whereLabel($roleLabel)->first();
		} catch(Exception $e) {
			Log::channel('role')->error('[RoleRepository:getFirstRoleByLabel] First role not fetched by label because an exception occurred: ');
			Log::channel('role')->error($e->getMessage());

			return false;
		}
	}
}