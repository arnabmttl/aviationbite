<?php

namespace App\Repositories;

// Model for this repository
use App\Models\Section;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class SectionRepository extends BaseRepository
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
	 * Create a new section by pageable object.
	 *
	 * @param  array  $input
	 * @param  mixed  $pageableObject
	 * @return \App\Models\Section|boolean
	 */
	public function createSectionByPageableObject($input, $pageableObject)
	{
		try {
			$newSection = new Section($input);

			return $pageableObject->sections()->save($newSection);
		} catch (Exception $e) {
			Log::channel('section')->error('[SectionRepository:createSectionByPageableObject] New section not created by pageable object because an exception occurred: ');
			Log::channel('section')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Update the section by object.
	 *
	 * @param  array  $update
	 * @param  \App\Models\Section  $section
	 * @return boolean
	 */
	public function updateSectionByObject($update, $section)
	{
		try {
			return $section->update($update);
		} catch (Exception $e) {
			Log::channel('section')->error('[SectionRepository:updateSectionByObject] Section not updated by object because an exception occurred: ');
			Log::channel('section')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Add sectionable to section by object.
	 *
	 * @param  \App\Models\Section  $section
	 * @param  mixed  $sectionableObject
	 * @return mixed|boolean
	 */
	public function addSectionableToSectionByObject($section, $sectionableObject)
	{
		try {
			return $sectionableObject->sections()->save($section);
		} catch (Exception $e) {
			Log::channel('section')->error('[SectionRepository:addSectionableToSectionByObject] Sectionable not added to section by object because an exception occurred: ');
			Log::channel('section')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Delete the section by object.
	 *
	 * @param  \App\Models\Section  $section
	 * @return boolean
	 */
	public function deleteSectionByObject($section)
	{
		try {
			return $section->delete();
		} catch (Exception $e) {
			Log::channel('section')->error('[SectionRepository:deleteSectionByObject] Section not deleted by object because an exception occurred: ');
			Log::channel('section')->error($e->getMessage());

			return false;
		}
	}
}