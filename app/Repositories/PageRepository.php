<?php

namespace App\Repositories;

// Model for this repository
use App\Models\Page;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class PageRepository extends BaseRepository
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
	 * Get paginated list of pages.
	 *
	 * @param  int  $perPage
	 * @return \Illuminate\Pagination\LengthAwarePaginator|boolean
	 */
	public function getPaginatedListOfPages($perPage)
	{
		try {
			return Page::paginate($perPage);
		} catch (Exception $e) {
			Log::channel('page')->error('[PageRepository:getPaginatedListOfPages] Paginated list of pages not fetched because an exception occurred: ');
			Log::channel('page')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Create a new page.
	 *
	 * @param  array  $input
	 * @return \App\Models\Page|boolean
	 */
	public function createPage($input)
	{
		try {
			return Page::create($input);
		} catch (Exception $e) {
			Log::channel('page')->error('[PageRepository:createPage] New page not created because an exception occurred: ');
			Log::channel('page')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Update the page by object.
	 *
	 * @param  array  $update
	 * @param  \App\Models\Page  $page
	 * @return boolean
	 */
	public function updatePageByObject($update, $page)
	{
		try {
			return $page->update($update);
		} catch (Exception $e) {
			Log::channel('page')->error('[PageRepository:updatePageByObject] Page not updated by object because an exception occurred: ');
			Log::channel('page')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Delete the page by object.
	 *
	 * @param  \App\Models\Page  $page
	 * @return boolean
	 */
	public function deletePageByObject($page)
	{
		
		try {
			return $page->delete();
		} catch (Exception $e) {
			Log::channel('page')->error('[PageRepository:deletePageByObject] Page not deleted by object because an exception occurred: ');
			Log::channel('page')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get first page by id.
	 *
	 * @param  int  $id
	 * @return \App\Models\Page|boolean
	 */
	public function getFirstPageById($id)
	{
		try {
			return Page::whereId($id)->first();
		} catch(Exception $e) {
			Log::channel('page')->error('[PageRepository:getFirstPageById] First page not fetched by id because an exception occurred: ');
			Log::channel('page')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get first page by slug.
	 *
	 * @param  string  $slug
	 * @return \App\Models\Page|boolean
	 */
	public function getFirstPageBySlug($slug)
	{
		try {
			return Page::whereSlug($slug)->first();
		} catch(Exception $e) {
			Log::channel('page')->error('[PageRepository:getFirstPageBySlug] First page not fetched by slug because an exception occurred: ');
			Log::channel('page')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get plucked list of pages by title and id.
	 *
	 * @return \Illuminate\Support\Collection|boolean
	 */
	public function getPluckedListOfPagesByTitleAndId()
	{
		try {
			return Page::pluck('title', 'id');
		} catch(Exception $e) {
			Log::channel('page')->error('[PageRepository:getPluckedListOfPagesByTitleAndId] Plucked list of pages by title and id not fetched because an exception occurred: ');
			Log::channel('page')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Get the total number of pages available.
	 *
	 * @return int|boolean
	 */
	public function getTotalPages()
	{
		try {
			return Page::count();
		} catch(Exception $e) {
			Log::channel('page')->error('[PageRepository:getTotalPages] Total number of pages not fetched because an exception occurred: ');
			Log::channel('page')->error($e->getMessage());

			return false;
		}
	}
}