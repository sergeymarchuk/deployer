<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'administrator']);
        $admin->givePermissionTo('users_manage', 'projects_manage', 'deploy');
        $deployer = Role::create(['name' => 'deployer']);
        $deployer->givePermissionTo('deploy');
    }
}
