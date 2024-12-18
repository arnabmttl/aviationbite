<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Repositories
use App\Repositories\DifficultyLevelRepository;

class DifficultyLevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Check if any difficulty level(s) exist or not. If no difficulty level exists then only create 
         * difficulty levels.
         */
        $difficultyLevelRepository = new DifficultyLevelRepository;
        $numberOfDifficultyLevels = $difficultyLevelRepository->getTotalDifficultyLevels();

        if ($numberOfDifficultyLevels == 0) {
        	$difficultyLevelRepository->createDifficultyLevel([
        		'title' => 'Beginner'
        	]);

        	$difficultyLevelRepository->createDifficultyLevel([
        		'title' => 'Intermediate'
        	]);

        	$difficultyLevelRepository->createDifficultyLevel([
        		'title' => 'Advance'
        	]);
        }
    }
}
