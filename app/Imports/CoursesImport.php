<?php

namespace App\Imports;

// Services
use App\Services\CourseService;
use App\Services\TopicService;

// Support Facades
use Illuminate\Support\Str;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CoursesImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $topicIds = (new TopicService)->getTopicIdsFromCommaSeparatedTopicNames($row['topics']);

        if ($topicIds) {
            $courseService = new CourseService;

            $slug = Str::slug($row['name']);
            if ($courseService->getFirstCourseBySlug($slug))
                $slug = $slug . '-latest';

            $courseInput['topics'] = $topicIds;
            $courseInput['name'] = $row['name'];
            $courseInput['slug'] = $slug;
            $courseInput['price'] = $row['price'];
            $courseInput['special_price'] = $row['special_price'];
            $courseInput['valid_for'] = $row['valid_for'];
            $courseInput['is_active'] = ($row['is_active'] == 'Yes') ? 1 : 0;
            $courseInput['short_description'] = $row['short_description'];
            $courseInput['description'] = $row['description'];

            return $courseService->createCourse($courseInput);
        }

        return null;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:courses',
            'topics' => 'required',
            'price' => 'required|numeric|min:0',
            'special_price' => 'required|numeric|lt:*.price',
            'valid_for' => 'required|numeric|min:1',
            'is_active' => 'required|in:Yes,No',
            'short_description' => 'required',
            'description' => 'required'
        ];
    }
}
