<?php

namespace App\Repositories;

// Model for the repository
use App\Models\CourseChapterContent;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class CourseChapterContentRepository extends BaseRepository
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
	 * Create a new CourseChapter.
	 *
	 * @param  array  $input
	 * @return \App\Models\CourseChapterContent
	 */
	public function createCourseChapterContent($input)
	{
		return CourseChapterContent::create($input);
	}


}