<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Repositories
use App\Repositories\MenuItemRepository;

class MenuItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Check if any menu item(s) exist or not.
         * If no menu item exists then only create menu items.
         */
        $menuItemRepository = new MenuItemRepository;
        $numberOfMenuItems = $menuItemRepository->getTotalMenuItems();

        if($numberOfMenuItems == 0) {
        	$menuItemRepository->createMenuItem([
        		'title' => 'Home',
        		'redirection_url' => route('home'),
                'sort_order' => 1
        	]);
        }
    }
}
