<?php

namespace App\Repositories;

// Model for the repository
use App\Models\SectionView;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class SectionViewRepository extends BaseRepository
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
	 * Get the paginated list of section views ordered by updated at.
	 *
	 * @param  int  $perPage
	 * @return \Illuminate\Pagination\LengthAwarePaginator|boolean
	 */
	public function getPaginatedListOfSectionViewsOrderedByUpdatedAt($perPage)
	{
		try {
			return SectionView::orderBy('updated_at', 'desc')->paginate($perPage);
		} catch (Exception $e) {
			Log::channel('section')->error('[SectionViewRepository:getPaginatedListOfSectionViewsOrderedByUpdatedAt] Paginated list of section views ordered by updated at not fetched because an exception occurred: ');
			Log::channel('section')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Create a new section view.
	 *
	 * @param  array  $input
	 * @return \App\Models\SectionView|boolean
	 */
	public function createSectionView($input)
	{
		try {
			return SectionView::create($input);
		} catch (Exception $e) {
			Log::channel('section')->error('[SectionViewRepository:createSectionView] New section view not created because an exception occurred: ');
			Log::channel('section')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Update the section view by the object.
	 *
	 * @param  array  $update
	 * @param  \App\Models\SectionView  $sectionView
	 * @return boolean
	 */
	public function updateSectionViewByObject($update, $sectionView)
	{
		try {
			return $sectionView->update($update);
		} catch (Exception $e) {
			Log::channel('section')->error('[SectionViewRepository:updateSectionViewByObject] Section view not updated by object because an exception occurred: ');
			Log::channel('section')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Delete the section view by the object.
	 *
	 * @param  \App\Models\SectionView  $sectionView
	 * @return boolean
	 */
	public function deleteSectionViewByObject($sectionView)
	{
		try {
			return $sectionView->delete();
		} catch (Exception $e) {
			Log::channel('section')->error('[SectionViewRepository:deleteSectionViewByObject] Section view not deleted by object because an exception occurred: ');
			Log::channel('section')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get plucked list of section views by name and id.
	 *
	 * @return \Illuminate\Support\Collection|boolean
	 */
	public function getPluckedListOfSectionViewsByNameAndId()
	{
		try {
			return SectionView::pluck('name', 'id');
		} catch(Exception $e) {
			Log::channel('section')->error('[SectionViewRepository:getPluckedListOfSectionViewsByNameAndId] Plucked list of section views by name and id not fetched because an exception occurred: ');
			Log::channel('section')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get plucked list of section views by name and id exluding some.
	 *
	 * @param  array  $toBeExcluded
	 * @return \Illuminate\Support\Collection|boolean
	 */
	public function getPluckedListOfSectionViewsByNameAndIdExcludingSome($toBeExcluded)
	{
		try {
			return SectionView::whereNotIn('id', $toBeExcluded)->pluck('name', 'id');
		} catch(Exception $e) {
			Log::channel('section')->error('[SectionViewRepository:getPluckedListOfSectionViewsByNameAndIdExcludingSome] Plucked list of section views by name and id excluding some not fetched because an exception occurred: ');
			Log::channel('section')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get plucked list of section views by name and type exluding some.
	 *
	 * @param  array  $toBeExcluded
	 * @return \Illuminate\Support\Collection|boolean
	 */
	public function getPluckedListOfSectionViewsByNameAndTypeExcludingSome($toBeExcluded)
	{
		try {
			return SectionView::whereNotIn('id', $toBeExcluded)->pluck('name', 'type');
		} catch(Exception $e) {
			Log::channel('section')->error('[SectionViewRepository:getPluckedListOfSectionViewsByNameAndTypeExcludingSome] Plucked list of section views by name and type excluding some not fetched because an exception occurred: ');
			Log::channel('section')->error($e->getMessage());

			return false;
		}
	}

	/**
     * Get the first section view by the type.
     *
     * @param  int  $type
     * @return \App\Models\SectionView|boolean
     */
    public function getFirstSectionViewByType($type)
    {
        try {
            return SectionView::whereType($type)->first();
        } catch (Exception $e) {
            Log::channel('course')->error('[SectionViewRepository:getFirstSectionViewByType] First section view by type not fetched because an exception occured: ');
            Log::channel('course')->error($e->getMessage());

            return false;
        }
    }

    /**
	 * Get the total number of section views available.
	 *
	 * @return int|boolean
	 */
	public function getTotalSectionViews()
	{
		try {
			return SectionView::count();
		} catch(Exception $e) {
			Log::channel('section')->error('[SectionViewRepository:getTotalSectionViews] Total number of section views not fetched because an exception occurred: ');
			Log::channel('section')->error($e->getMessage());

			return false;
		}
	}
}