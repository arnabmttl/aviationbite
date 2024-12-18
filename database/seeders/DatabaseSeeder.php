<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(TaxesTableSeeder::class);
        $this->call(QuestionTypesTableSeeder::class);
        $this->call(DifficultyLevelsTableSeeder::class);
        $this->call(ChannelsTableSeeder::class);
        $this->call(MenuItemsTableSeeder::class);
        $this->call(FootersTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(SectionViewsTableSeeder::class);
    }
}
