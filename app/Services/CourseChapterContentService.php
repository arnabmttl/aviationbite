<?php

namespace App\Services;

// Repositories
use App\Repositories\CourseChapterContentRepository;

// Models
use App\Models\Document;
use App\Models\CourseChapterContent;

// Support Facades
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CourseChapterContentService extends BaseService
{
	/**
	 * CourseChapterRepository instance to use various functions of CourseChapterContentRepository.
	 *
	 * @var \App\Repositories\CourseChapterContentRepository
	 */
	protected $courseChapterContentRepository;

	/**
	 * Create a new service instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->courseChapterContentRepository = new CourseChapterContentRepository;
	}

	/**
	 * Create a new chapter.
	 *
	 * @param  array  $input
	 * @return \App\Models\chapter
	 */
	public function createCourseChapterContent($input)
	{
		try
		{
			/**
		    * Save the image in temporary variable for uploading after the content is 
		    * created. And unset the 'image' as that is not to be inserted in database.
		    */
            $tempImage =  $input['file'];
			unset($input['file']);

			if($courseChapterContent = $this->courseChapterContentRepository->createCourseChapterContent($input))
			{
				/**
                * Save thumbnail image to storage.
                */
				$tempImage = Storage::put('/public/courses/chapters/documents',$tempImage);

				/**
		         * Create new document and save it using the relationship.
		         */
				$newImage = new Document;
				$newImage->document_type = $input['type'];
				$newImage->type = 'Document';
				$newImage->url = 'courses/chapters/documents/'.basename($tempImage);

				/**
				 * Save Image
				 * 
				 */
				return $courseChapterContent->documents()->save($newImage);
			}
		}catch(Exception $e){
			Log::channel('content')->error('[CourseChapterContent::CreateCourseChapterContent] Content not created because an exception occurred:');
			Log::channel('content')->error($e->getMessage());
		}
	}
	
	
}