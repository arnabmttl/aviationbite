<?php

namespace App\Services;

// Repositories
use App\Repositories\CourseChapterRepository;

// Imports
use App\Imports\ChaptersImport;

// Laravel Excel
use Maatwebsite\Excel\Facades\Excel;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class CourseChapterService extends BaseService
{
	/**
	 * TopicRepository instance to use various functions of CourseChapterRepository.
	 *
	 * @var \App\Repositories\CourseChapterRepository
	 */
	protected $courseChapterRepository;

	/**
	 * Create a new service instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->courseChapterRepository = new CourseChapterRepository;
	}

	/**
	 * Create a new chapter.
	 *
	 * @param  array  $input
	 * @return \App\Models\chapter
	 */
	public function createCourseChapter($input)
	{

		return $this->courseChapterRepository->createCourseChapter($input);
	}
	

	/**
	 * Update the courseChapter by the object.
	 *
	 * @param  array  $update
	 * @param  \App\Models\CourseChapter  $courseChapter
	 * @return boolean
	 */
	public function updateCourseChapterByObject($update, $chapter)
	{
		return $this->courseChapterRepository->updateCourseChapterByObject($update, $chapter);
	}

	/**
	 * Upload the chapters from the excel.
	 *
	 * @param  \Illuminate\Http\UploadedFile  $uploadedFile
	 * @return array
	 */
	public function uploadChaptersExcel($uploadedFile)
	{
		try {
			Excel::import(new ChaptersImport(), $uploadedFile);

			return [
				'result' => 1
			];
		} catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
			return [
				'result' => 2,
				'failures' => $e->failures()
			];
		} catch (Exception $e) {
			Log::channel('chapter')->error('[CourseChapterService:uploadChaptersExcel] Chapters excel not uploaded because an exception occurred: ');
			Log::channel('chapter')->error($e->getMessage());

			return [
				'result' => 0
			];
		}
	}

	/**
     * Get the first course chapter by the name.
     *
     * @param  string  $name
     * @return \App\Models\CourseChapter|boolean
     */
    public function getFirstCourseChapterByName($name)
    {
    	try {
        	return $this->courseChapterRepository->getFirstCourseChapterByName($name);
        } catch (Exception $e) {
			Log::channel('chapter')->error('[CourseChapterService:getFirstCourseChapterByName] First course chapter not fetched by name because an exception occurred: ');
			Log::channel('chapter')->error($e->getMessage());

			return false;
		}
    }

    /**
     * Get the first course chapter by the name and course id.
     *
     * @param  string  $name
     * @param  int  $courseId
     * @return \App\Models\CourseChapter|boolean
     */
    public function getFirstCourseChapterByNameAndCourseId($name, $courseId)
    {
    	try {
        	return $this->courseChapterRepository->getFirstCourseChapterByNameAndCourseId($name, $courseId);
        } catch (Exception $e) {
			Log::channel('chapter')->error('[CourseChapterService:getFirstCourseChapterByNameAndCourseId] First course chapter not fetched by name and course id because an exception occurred: ');
			Log::channel('chapter')->error($e->getMessage());

			return false;
		}
    }
}