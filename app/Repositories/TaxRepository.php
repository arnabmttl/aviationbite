<?php

namespace App\Repositories;

// Model for the repository
use App\Models\Tax;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class TaxRepository extends BaseRepository
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
	 * Get the total number of taxes available.
	 *
	 * @return int|boolean
	 */
	public function getTotalTaxes()
	{
		try {
			return Tax::count();
		} catch (Exception $e) {
			Log::channel('tax')->error('[TaxRepository:getTotalTaxes] Total taxes not fetched because an exception occurred: ');
			Log::channel('tax')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Create a new tax.
	 *
	 * @param  array  $input
	 * @return \App\Models\Tax|boolean
	 */
	public function createTax($input)
	{
		try {
			return Tax::create($input);
		} catch (Exception $e) {
			Log::channel('tax')->error('[TaxRepository:createTax] New tax not created because an exception occurred: ');
			Log::channel('tax')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get paginated list of taxes.
	 *
	 * @param  int  $perPage
	 * @return \Illuminate\Pagination\LengthAwarePaginator|boolean
	 */
	public function getPaginatedListOfTaxes($perPage)
	{
		try {
			return Tax::paginate($perPage);
		} catch (Exception $e) {
			Log::channel('tax')->error('[TaxRepository:getPaginatedListOfTaxes] Paginated list of taxes not fetched because an exception occurred: ');
			Log::channel('tax')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Update the tax by object.
	 *
	 * @param  array  $update
	 * @param  \App\Models\Tax  $tax
	 * @return boolean
	 */
	public function updateTaxByObject($update, $tax)
	{
		try {
			return $tax->update($update);
		} catch (Exception $e) {
			Log::channel('tax')->error('[TaxRepository:updateTaxByObject] Tax not updated by object because an exception occurred: ');
			Log::channel('tax')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get first tax by label.
	 *
	 * @param  string  $label
	 * @return \App\Models\Tax|boolean
	 */
	public function getFirstTaxByLabel($label)
	{
		try {
			return Tax::whereLabel($label)->first();
		} catch (Exception $e) {
			Log::channel('tax')->error('[TaxRepository:getFirstTaxByLabel] First tax by label not fetched because an exception occurred: ');
			Log::channel('tax')->error($e->getMessage());

			return false;
		}
	}
}