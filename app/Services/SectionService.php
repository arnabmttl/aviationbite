<?php

namespace App\Services;

// Models
use App\Models\Image;

// Services
use App\Services\CollectionService;

// Repositories
use App\Repositories\SectionViewRepository;
use App\Repositories\SectionRepository;
use App\Repositories\FaqRepository;

// Support Facades
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

// Exception
use Exception;

class SectionService extends BaseService
{
	/**
	 * SectionViewRepository instance to use various functions of SectionViewRepository.
	 *
	 * @var \App\Repositories\SectionViewRepository
	 */
	protected $sectionViewRepository;

	/**
	 * SectionRepository instance to use various functions of SectionRepository.
	 *
	 * @var \App\Repositories\SectionRepository
	 */
	protected $sectionRepository;

	/**
     * CollectionService instance to use various functions of CollectionService.
     *
     * @var \App\Services\CollectionService
     */
    protected $collectionService;

	/**
	 * Create a new service instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->sectionViewRepository = new SectionViewRepository;
		$this->sectionRepository = new SectionRepository;
		$this->collectionService = new CollectionService;
	}

	/**
	 * Get the paginated list of section views by updated at.
	 *
	 * @param  int  $perPage
	 * @return \Illuminate\Pagination\LengthAwarePaginator|boolean
	 */
	public function getPaginatedListOfSectionViewsOrderedByUpdatedAt($perPage)
	{
		try {
			return $this->sectionViewRepository->getPaginatedListOfSectionViewsOrderedByUpdatedAt($perPage);
		} catch (Exception $e) {
			Log::channel('section')->error('[SectionService:getPaginatedListOfSectionViewsOrderedByUpdatedAt] Paginated list of section views ordered by updated at not fetched because an exception occurred: ');
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
			/**
			 * IF section view is created successfully
			 * THEN create corresponding blade file for this section view.
			 */
			if ($sectionView = $this->sectionViewRepository->createSectionView($input)) {
				file_put_contents('../resources/views/frontend/page/partial/'.$sectionView->type.'.blade.php', html_entity_decode($sectionView->content));
			}

			return $sectionView;
		} catch (Exception $e) {
			Log::channel('section')->error('[SectionService:createSectionView] New section view not created because an exception occurred: ');
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
			/**
			 * IF section view is updated successfully
			 * THEN create/replace corresponding blade file for this section view.
			 */
			if ($result = $this->sectionViewRepository->updateSectionViewByObject($update, $sectionView)) {
				file_put_contents('../resources/views/frontend/page/partial/'.$sectionView->type.'.blade.php', html_entity_decode($sectionView->content));
			}

			return $result;
		} catch (Exception $e) {
			Log::channel('section')->error('[SectionService:updateSectionViewByObject] Section view not updated by object because an exception occurred: ');
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
			return $this->sectionViewRepository->deleteSectionViewByObject($sectionView);
		} catch (Exception $e) {
			Log::channel('section')->error('[SectionService:deleteSectionViewByObject] Section view not deleted by object because an exception occurred: ');
			Log::channel('section')->error($e->getMessage());

			return false;
		}
	}

	/**
     * Add section based on type.
     *
     * @param  array  $input
     * @return \App\Models\Section|boolean
     */
    public function createSection($input)
    {
    	try {
	        $item = false;
	        switch ($input['type']) {
	            case 'page': $item = (new PageService)->getFirstPageById($input['typeId']);
	                            break;
	        }
	        
	        if ($item) {
	        	/**
	        	 * Create input for section creation.
	        	 * For the optional elements
	        	 * IF input is containing that element
	        	 * THEN assign the same
	        	 * ELSE give null
	        	 */
	            $sectionInput['margin_top'] = $input['margin_top'];
	            $sectionInput['margin_bottom'] = $input['margin_bottom'];
	            $sectionInput['bg_color'] = isset($input['bg_color']) ? $input['bg_color'] : 0;
	            $sectionInput['title'] = isset($input['title']) ? $input['title'] : '';
	            $sectionInput['sub_title'] = isset($input['sub_title']) ? $input['sub_title'] : null;
	            $sectionInput['description'] = isset($input['description']) ? $input['description'] : null;
	            $sectionInput['redirection_url'] = isset($input['redirection_url']) ? $input['redirection_url'] : null;
	            $sectionInput['sort_order'] = $item->sections->count() + 1;

	            /**
	             * Section view type is coming from input
	             * So need to fetch the section view by type
	             * Then assign the id to section_view_id input.
	             */
	            $sectionInput['section_view_id'] = $this->sectionViewRepository->getFirstSectionViewByType($input['section_view_id'])->id;

	            if ($newSection = $this->sectionRepository->createSectionByPageableObject($sectionInput, $item)) {
	            	/**
	                 * If 'desktop_image' exists in input that means it is for banner.
	                 */
	                if (isset($input['desktop_image'])) {
	                    /**
	                     * Create new collection and attach with the newly created section.
	                     */
	                    $collectionInput['name'] = $item->title.' Banners';
	                    $collectionInput['is_sub_section'] = 1;

	                    if ($collectionOfBanners = $this->collectionService->createCollection($collectionInput)) {
	                        $this->sectionRepository->addSectionableToSectionByObject($newSection, $collectionOfBanners);
	                    } else
	                        return false;

	                    /**
	                     * Save desktop and mobile banner image and attach it to the page 
	                     * and later with the collection as well. 
	                     */
	                    $desktopImage = Storage::put('/public/banners/desktop', $input['desktop_image']);
	                    $mobileImage = Storage::put('/public/banners/mobile', $input['mobile_image']);

	                    /**
	                     * Create new image and save it using the relationship.
	                     */
	                    $newImage = new Image;
	                    $newImage->type = 'Desktop Banner';
	                    $newImage->url = 'banners/desktop/'.basename($desktopImage);
	                    $newImage->text = isset($input['banner_text']) ? $input['banner_text'] : null;
	                    $newImage->redirection_url = isset($input['banner_redirection_url']) ? $input['banner_redirection_url'] : null;
	                    $newImage->button_text = isset($input['banner_button_text']) ? $input['banner_button_text'] : null;

	                    $desktopImage = $item->images()->save($newImage);

	                    /**
	                     * Create new image and save it using the relationship.
	                     */
	                    $newImage = new Image;
	                    $newImage->type = 'Mobile Banner';
	                    $newImage->url = 'banners/mobile/'.basename($mobileImage);
	                    $newImage->text = isset($input['banner_text']) ? $input['banner_text'] : null;
	                    $newImage->redirection_url = isset($input['banner_redirection_url']) ? $input['banner_redirection_url'] : null;
	                    $newImage->button_text = isset($input['banner_button_text']) ? $input['banner_button_text'] : null;

	                    $mobileImage = $desktopImage->image()->save($newImage);

	                    return $this->collectionService->createCollectionItemByCollectionAndCollectableObject($collectionOfBanners, $desktopImage);
	                }

	                /**
	                 * If 'section_image' exists in input that means section has an image component.
	                 */
	                if (isset($input['section_image'])) {
	                    /**
	                     * Save section image and attach it to the section.
	                     */
	                    $sectionImage = Storage::put('/public/sections/images', $input['section_image']);

	                    /**
	                     * Create new image and save it using the relationship.
	                     */
	                    $newImage = new Image;
	                    $newImage->type = 'Section Image';
	                    $newImage->url = 'sections/images/'.basename($sectionImage);

	                    $newSection->image()->save($newImage);

	                    return $newSection;
	                }

	                /**
	                 * If 'collection_id' exists in input that means it is for a collection type.
	                 */
	                if (isset($input['collection_id']) && ($collection = $this->collectionService->getFirstCollectionById($input['collection_id']))) {
	                    $update['title'] = $collection->name;
	                    $this->sectionRepository->updateSectionByObject($update, $newSection);

	                    return $this->sectionRepository->addSectionableToSectionByObject($newSection, $collection);
	                }

	                /**
	                 * If 'faq_question' exists in input that means it is for a faq type.
	                 */
	                if (isset($input['faq_question'])) {
	                    return $this->addFaqBySectionObject($input, $newSection);
	                }
	            }

	            return $newSection;
	        } else {
	            return false;
	        }
	    } catch (Exception $e) {
	    	Log::channel('section')->error('[SectionService:createSection] Section not created because an exception occurred: ');
			Log::channel('section')->error($e->getMessage());

			return false;
	    }
    }

    /**
     * Delete section by object.
     *
     * @param  \App\Models\Section  $section
     * @return boolean
     */
    public function deleteSectionByObject($section)
    {
    	try {
	        /**
	         * Change sort order of other sections before deleting the section.
	         */
	        $sortOrder = $section->sort_order;
	        $result = true;
	        foreach ($section->pageable->sections->where('sort_order', '>', $section->sort_order) as $otherSection) {
	            $update['sort_order'] = $sortOrder++;
	            $result = $result && $this->sectionRepository->updateSectionByObject($update, $otherSection);
	        }

	        return $this->sectionRepository->deleteSectionByObject($section);
	    } catch (Exception $e) {
			Log::channel('section')->error('[SectionService:deleteSectionByObject] Section not deleted by object because an exception occurred: ');
			Log::channel('section')->error($e->getMessage());

			return false;
		}
    }

    /**
     * Add banner for a page by the section object.
     *
     * @param  array  $input
     * @param  \App\Models\Section  $section
     * @return boolean
     */
    public function addBannerForPageBySectionObject($input, $section)
    {
    	try {
	        /**
	         * Check if collection is already attached with the section or not.
	         * If already attached then create banner and attach it to the related collection.
	         * If not already attached then create collection before creating the banner.
	         */
	        if (!($collectionOfBanners = $section->sectionable)) {
	            $collectionInput['name'] = $section->pageable->title.' Banners';
	            $collectionInput['is_sub_section'] = 1;

	            if ($collectionOfBanners = $this->collectionService->createCollection($collectionInput)) {
	                $this->sectionRepository->addSectionableToSectionByObject($section, $collectionOfBanners);
	            } else
	                return false;
	        }

	        try {
	            /**
	             * Save desktop and mobile banner image and attach it to the page 
	             * and later with the collection as well. 
	             */
	            $desktopImage = Storage::put('/public/banners/desktop', $input['desktop_image']);
	            $mobileImage = Storage::put('/public/banners/mobile', $input['mobile_image']);

	            /**
	             * Create new image and save it using the relationship.
	             */
	            $newImage = new Image;
	            $newImage->type = 'Desktop Banner';
	            $newImage->url = 'banners/desktop/'.basename($desktopImage);
	            $newImage->text = isset($input['banner_text']) ? $input['banner_text'] : null;
	            $newImage->redirection_url = isset($input['banner_redirection_url']) ? $input['banner_redirection_url'] : null;
	            $newImage->button_text = isset($input['banner_button_text']) ? $input['banner_button_text'] : null;

	            $desktopImage = $section->pageable->images()->save($newImage);

	            /**
	             * Create new image and save it using the relationship.
	             */
	            $newImage = new Image;
	            $newImage->type = 'Mobile Banner';
	            $newImage->url = 'banners/mobile/'.basename($mobileImage);
	            $newImage->text = isset($input['banner_text']) ? $input['banner_text'] : null;
	            $newImage->redirection_url = isset($input['banner_redirection_url']) ? $input['banner_redirection_url'] : null;
	            $newImage->button_text = isset($input['banner_button_text']) ? $input['banner_button_text'] : null;

	            $mobileImage = $desktopImage->image()->save($newImage);

	            return $this->collectionService->createCollectionItemByCollectionAndCollectableObject($collectionOfBanners, $desktopImage);
	        } catch (Exception $e) {
	            Log::channel('section')->error('[SectionService:addBannerForPageBySectionObject] Banner for page by section object not added because an exception occured: ');
	            Log::channel('section')->error($e->getMessage());

	            return false;
	        }
	    } catch (Exception $e) {
			Log::channel('section')->error('[SectionService:addBannerForPageBySectionObject] Banner for page not added by section object because an exception occurred: ');
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
	        if ($section->image && isset($update['image'])) {
	            /**
	             * Remove previous section image from the table.
	             */
	            $section->image->delete();

	            /**
	             * Save section image and attach it to the section.
	             */
	            $sectionImage = Storage::put('/public/sections/images', $update['image']);

	            /**
	             * Create new image and save it using the relationship.
	             */
	            $newImage = new Image;
	            $newImage->type = 'Section Image';
	            $newImage->url = 'sections/images/'.basename($sectionImage);

	            $section->image()->save($newImage);
	        }

	        return $this->sectionRepository->updateSectionByObject($update, $section);
	    } catch (Exception $e) {
			Log::channel('section')->error('[SectionService:updateSectionByObject] Section not updated by object because an exception occurred: ');
			Log::channel('section')->error($e->getMessage());

			return false;
		}
    }

    /**
	 * Move the section up by object.
	 *
	 * @param  \App\Models\Section  $section
	 * @return boolean
	 */
	public function moveSectionUpByObject($section)
	{
		try {
	        /**
	         * Sort order can be changed only if it is greater than 1.
	         */
	        if ($section->sort_order > 1) {
	            $newSortOrder = $section->sort_order - 1;
	            
	            return $this->changeSortOrderByObject($newSortOrder, $section);
	        }

	        return false;
	    } catch (Exception $e) {
			Log::channel('section')->error('[SectionService:moveSectionUpByObject] Section not moved up by object because an exception occurred: ');
			Log::channel('section')->error($e->getMessage());

			return false;
		}
	}

    /**
     * Move the section down by object.
     *
     * @param  \App\Models\Section  $section
     * @return boolean
     */
    public function moveSectionDownByObject($section)
    {
    	try {
	        /**
	         * Sort order can be changed only if it is not the last section.
	         */
	        if ($section->sort_order < $section->pageable->sections->count()) {
	            $newSortOrder = $section->sort_order + 1;
	            
	            return $this->changeSortOrderByObject($newSortOrder, $section);
	        }

	        return false;
	    } catch (Exception $e) {
			Log::channel('section')->error('[SectionService:moveSectionDownByObject] Section not moved down by object because an exception occurred: ');
			Log::channel('section')->error($e->getMessage());

			return false;
		}
    }

    /**
     * Change sort order for a section by object.
     *
     * @param  int  $newSortOrder
     * @param  \App\Models\Section  $section
     */
    public function changeSortOrderByObject($newSortOrder, $section)
    {
    	try {
	        $result = true;

	        /**
	         * Check of any section exist with the new sort order or not.
	         * If so then replace the sort orders for both sections.
	         */
	        if ($anotherSection = $section->pageable->sections()->whereSortOrder($newSortOrder)->first()) {
	            $update['sort_order'] = $section->sort_order;
	            $result = $result && $this->sectionRepository->updateSectionByObject($update, $anotherSection);

	            $update['sort_order'] = $newSortOrder;
	            $result = $result && $this->sectionRepository->updateSectionByObject($update, $section);
	        } else {
	            $update['sort_order'] = $newSortOrder;
	            $result = $result && $this->sectionRepository->updateSectionByObject($update, $section);
	        }

	        return $result;
	    } catch (Exception $e) {
			Log::channel('section')->error('[SectionService:changeSortOrderByObject] Sort order not changed by object because an exception occurred: ');
			Log::channel('section')->error($e->getMessage());

			return false;
		}
    }

    /**
     * Add faq by the section object.
     *
     * @param  array  $input
     * @param  \App\Models\Section  $section
     * @return boolean
     */
    public function addFaqBySectionObject($input, $section)
    {
        /**
         * Check if collection is already attached with the section or not.
         * If already attached then create faq and attach it to the related collection.
         * If not already attached then create collection before creating the faq.
         */
        if (!($collectionOfFaqs = $section->sectionable)) {
            $collectionInput['name'] = $section->pageable->title.' FAQs';
            $collectionInput['is_sub_section'] = 1;

            if ($collectionOfFaqs = $this->collectionService->createCollection($collectionInput)) {
                $this->sectionRepository->addSectionableToSectionByObject($section, $collectionOfFaqs);
            } else
                return false;
        }

        /**
         * Create input for faq.
         */
        $faqInput['questionable_id'] = $section->pageable_id;
        $faqInput['questionable_type'] = $section->pageable_type;
        $faqInput['question'] = $input['faq_question'];
        $faqInput['answer'] = $input['faq_answer'];

        /**
         * If new faq is created succesfully then do the further processing 
         * else return false. 
         */
        $faqRepository = new FaqRepository;
        if($newFaq = $faqRepository->createFaq($faqInput))
            return $this->collectionService->createCollectionItemByCollectionAndCollectableObject($collectionOfFaqs, $newFaq);
        else
            return false;
    }
}