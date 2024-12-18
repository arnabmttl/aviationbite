<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Repositories
use App\Repositories\QuestionTypeRepository;

class QuestionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Check if any question type(s) exist or not. If no question type exists then only create question type.
         */
        $questionTypeRepository = new QuestionTypeRepository;
        $numberOfQuestionTypes = $questionTypeRepository->getTotalQuestionTypes();

        if ($numberOfQuestionTypes == 0) {
        	$questionTypeRepository->createQuestionType([
        		'title' => 'Numerical'
        	]);

        	$questionTypeRepository->createQuestionType([
        		'title' => 'Theoratical'
        	]);

        	$questionTypeRepository->createQuestionType([
        		'title' => 'Pictorial'
        	]);
        }
    }
}
