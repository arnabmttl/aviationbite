<?php

namespace App\Imports;

// Services
use App\Services\CourseService;
use App\Services\CourseChapterService;
use App\Services\QuestionService;

// Repositories
use App\Repositories\DifficultyLevelRepository;
use App\Repositories\QuestionTypeRepository;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

// Support Facades
use Illuminate\Support\Facades\Log;
// Model
use App\Models\Question;
use App\Models\QuestionOption;

class QuestionsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $course = (new CourseService)->getFirstCourseByName(trim($row['course_name']));
        
        if ($course) {
            $courseChapter = (new CourseChapterService)->getFirstCourseChapterByNameAndCourseId(trim($row['chapter_name']), $course->id);
            $difficultyLevel = (new DifficultyLevelRepository)->getFirstDifficultyLevelByTitle(trim($row['difficulty_level']));
            $questionType = (new QuestionTypeRepository)->getFirstQuestionTypeByTitle(trim($row['question_type']));

            if ($courseChapter && ($course->id == $courseChapter->course_id) && $difficultyLevel && $questionType) {
                $questionInput['question_id'] = $row['question_id'];
                $questionInput['course_id'] = $courseChapter->course_id;
                $questionInput['course_chapter_id'] = $courseChapter->id;
                $questionInput['difficulty_level_id'] = $difficultyLevel->id;
                $questionInput['question_type_id'] = $questionType->id;
                $questionInput['previous_years'] = $row['previous_years'];
                $questionInput['title'] = $row['question'];
                $questionInput['description'] = $row['description'];
                $questionInput['explanation'] = $row['explanation'];
                $questionInput['option_title'][1] = $row['option_1_title'];
                $questionInput['is_correct'][1] = ($row['option_1_is_correct'] == 'Yes') ? 1 : 0;
                $questionInput['option_title'][2] = $row['option_2_title'];
                $questionInput['is_correct'][2] = ($row['option_2_is_correct'] == 'Yes') ? 1 : 0;
                $questionInput['option_title'][3] = $row['option_3_title'];
                $questionInput['is_correct'][3] = ($row['option_3_is_correct'] == 'Yes') ? 1 : 0;
                $questionInput['option_title'][4] = $row['option_4_title'];
                $questionInput['is_correct'][4] = ($row['option_4_is_correct'] == 'Yes') ? 1 : 0;

                // if ($question = (new QuestionService)->createQuestion($questionInput))
                if ($question = (new QuestionService)->createQuestionCSV($questionInput))                
                    return $question;
                else
                    return null;
            }
        }

        return null;
    }

    public function rules(): array
    {
        return [
            'question_id' => 'required|string|max:255|unique:questions',
            'course_name' => 'required|string|max:255|exists:courses,name',
            'chapter_name' => 'required|string|max:255|exists:course_chapters,name',
            'difficulty_level' => 'required|in:Beginner,Intermediate,Advance',
            'question_type' => 'required|in:Numerical,Theoratical,Pictorial',
            'previous_years' => 'nullable|max:255',
            'question' => 'required|string',
            'description' => 'nullable|string',
            'explanation' => 'nullable|string',
            'option_1_title' => 'required',
            'option_1_is_correct' => 'required|in:Yes,No',
            'option_2_title' => 'required',
            'option_2_is_correct' => 'required|in:Yes,No',
            'option_3_title' => 'required',
            'option_3_is_correct' => 'required|in:Yes,No',
            'option_4_title' => 'required',
            'option_4_is_correct' => 'required|in:Yes,No',
        ];
    }
}
