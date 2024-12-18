<?php

namespace App\Services;

// Repositories
use App\Repositories\PageRepository;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class PageService extends BaseService
{
	/**
	 * PageRepository instance to use various functions of PageRepository.
	 *
	 * @var \App\Repositories\PageRepository
	 */
	protected $pageRepository;

	/**
	 * Create a new service instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->pageRepository = new PageRepository;
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
			return $this->pageRepository->getPaginatedListOfPages($perPage);
		} catch (Exception $e) {
			Log::channel('page')->error('[PageService:getPaginatedListOfPages] Paginated list of pages not fetched because an exception occurred: ');
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
			return $this->pageRepository->createPage($input);
		} catch (Exception $e) {
			Log::channel('page')->error('[PageService:createPage] New page not created because an exception occurred: ');
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
			return $this->pageRepository->updatePageByObject($update, $page);
		} catch (Exception $e) {
			Log::channel('page')->error('[PageService:updatePageByObject] Page not updated by object because an exception occurred: ');
			Log::channel('page')->error($e->getMessage());

			return false;
		}
	}

	/**
	 * Delete page by object.
	 *
	 * @param  \App\Models\Page  $page
	 * @return boolean
	 */
	public function deletePageByObject($page)
	{
		try {
			if($page->slug == 'home-page')
				return false;
			else
			    return $this->pageRepository->deletePageByObject($page);
		} catch (Exception $e) {
			Log::channel('page')->error('[PageService:deletePageByObject] Page not deleted by object because an exception occurred: ');
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
			return $this->pageRepository->getFirstPageById($id);
		} catch(Exception $e) {
			Log::channel('page')->error('[PageService:getFirstPageById] First page not fetched by id because an exception occurred: ');
			Log::channel('page')->error($e->getMessage());

			return false;
		}
	}

	/**
     * Get plucked list of pages.
     *
     * @return \Illuminate\Support\Collection|boolean
     */
    public function getPluckedListOfPages()
    {
    	try {
        	return $this->pageRepository->getPluckedListOfPagesByTitleAndId();
        } catch(Exception $e) {
			Log::channel('page')->error('[PageService:getPluckedListOfPages] Plucked list of pages not fetched because an exception occurred: ');
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
    		return $this->pageRepository->getFirstPageBySlug($slug);
    	} catch(Exception $e) {
			Log::channel('page')->error('[PageService:getFirstPageBySlug] First page not fetched by slug because an exception occurred: ');
			Log::channel('page')->error($e->getMessage());

			return false;
		}
    }
}