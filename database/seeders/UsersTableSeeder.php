<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Repositories
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Check if any user(s) exist or not. If no user exist then only create user.
         */
        $userRepository = new UserRepository();
        $numberOfUsers = $userRepository->getTotalUsers();

        if($numberOfUsers == 0) {
            /**
             * Check if admin role exists or not.
             * If exists, then create admin user.
             */
            $adminRole = (new RoleRepository())->getFirstRoleByLabel('admin');

            if ($adminRole) {
                $userRepository->createUser([
                    'role_id' => $adminRole->id,
                    'username' => 'the_lms_admin',
                    'name' => 'Administrator',
                    'email' => 'admin@lms.com',
                    'phone_number' => '0000000000',
                    'password' => bcrypt('test123456'),
                    'referral_code' => 'LmSAdMiN'
                ]);
            }
        }
    }
}
