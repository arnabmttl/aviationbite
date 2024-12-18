<?php

namespace App\Repositories;

// Model for this repository
use App\Models\Footer;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class FooterRepository extends BaseRepository
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
	 * Get the total number of footers available.
	 *
	 * @return int|boolean
	 */
	public function getTotalFooters()
	{
		try {
			return Footer::count();
		} catch(Exception $e) {
			Log::channel('footer')->error('[FooterRepository:getTotalFooters] Total footers not fetched because an exception occurred: ');
			Log::channel('footer')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Create a new footer.
	 *
	 * @param  array  $input
	 * @return \App\Models\Footer|boolean
	 */
	public function createFooter($input)
	{
		try {
			return Footer::create($input);
		} catch (Exception $e) {
			Log::channel('footer')->error('[FooterRepository:createFooter] New footer not created because an exception occurred: ');
			Log::channel('footer')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get the first footer.
	 *
	 * @return \App\Models\Footer|boolean
	 */
	public function getFirstFooter()
	{
		try {
			return Footer::first();
		} catch(Exception $e) {
			Log::channel('footer')->error('[FooterRepository:getFirstFooter] First footer not fetched because an exception occurred: ');
			Log::channel('footer')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Update the footer by object.
	 *
	 * @param  array  $update
	 * @param  \App\Models\Footer  $footer
	 * @return boolean
	 */
	public function updateFooterByObject($update, $footer)
	{
		try {
			return $footer->update($update);
		} catch (Exception $e) {
			Log::channel('footer')->error('[FooterRepository:updateFooterByObject] Footer not updated by object because an exception occurred: ');
			Log::channel('footer')->error($e->getMessage());

			return false;
		}
	}
}