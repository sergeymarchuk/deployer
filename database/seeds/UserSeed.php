<?php

use Illuminate\Database\Seeder;
use App\Models\User;

/**
 * Class UserSeed
 */
class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password')
        ]);
        $user->assignRole('administrator');

        $user = User::create([
            'name' => 'Deployer',
            'email' => 'deploy@deploy.com',
            'password' => bcrypt('deploy')
        ]);
        $user->assignRole('deployer');

    }
}
