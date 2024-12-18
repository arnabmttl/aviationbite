<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Repositories
use App\Repositories\PageRepository;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Check if any page(s) exist or not.
         * If no page exists then only create page(s).
         */
        $pageRepository = new PageRepository;
        $numberOfPages = $pageRepository->getTotalPages();

        if($numberOfPages == 0) {
        	$pageRepository->createPage([
        		'slug' => 'home-page',
        		'title' => 'Home Page'
        	]);
        }
    }
}
