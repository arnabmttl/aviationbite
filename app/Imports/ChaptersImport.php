<?php

namespace App\Imports;

// Services
use App\Services\CourseChapterService;
use App\Services\CourseService;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ChaptersImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if ($course = (new CourseService)->getFirstCourseByName(trim($row['course_name']))) {
	        $courseChapterInput['course_id'] = $course->id;
	        $courseChapterInput['name'] = trim($row['chapter_name']);
	        $courseChapterInput['description'] = $row['description'];
            $courseChapterInput['is_preview'] = ($row['is_preview'] == 'Yes') ? 1 : 0;
	        $courseChapterInput['sort_order'] = $course->chapters->count()+1;

	        if ($courseChapter = (new CourseChapterService)->createCourseChapter($courseChapterInput))
	        	return $courseChapter;
	        else
	        	return null;
        }

        return null;
    }

    public function rules(): array
    {
        return [
            'course_name' => 'required|string|max:255|exists:courses,name',
            'chapter_name' => 'required|string|max:255',
            'is_preview' => 'required|in:Yes,No',
            'description' => 'required'
        ];
    }
}
