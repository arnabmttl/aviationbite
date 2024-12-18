<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Repositories
use App\Repositories\RoleRepository;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Check if any role(s) exist or not. If no role exists then only create roles.
         */
        $roleRepository = new RoleRepository;
        $numberOfRoles = $roleRepository->getTotalRoles();

        if($numberOfRoles == 0) {
        	$roleRepository->createRole([
        		'name' => 'Admin',
        		'label' => 'admin'
        	]);

        	$roleRepository->createRole([
        		'name' => 'Teacher',
        		'label' => 'teacher'
        	]);

        	$roleRepository->createRole([
        		'name' => 'Student',
        		'label' => 'student'
        	]);
        }
    }
}
