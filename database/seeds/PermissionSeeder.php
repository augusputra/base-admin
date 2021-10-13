<?php

use Illuminate\Database\Seeder;
use App\Models\PermissionsModel;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public $permissions = ([
        ['group' => 'User', 'name' => 'view-user-list', 'display_name' => 'View User List', 'description' => ''],
        ['group' => 'User', 'name' => 'create-user', 'display_name' => 'Create User', 'description' => ''],
        ['group' => 'User', 'name' => 'edit-user', 'display_name' => 'Edit User', 'description' => ''],
        ['group' => 'User', 'name' => 'delete-user', 'display_name' => 'Delete User', 'description' => ''],
        ['group' => 'User', 'name' => 'change-user-password', 'display_name' => 'Change User Password', 'description' => ''],
        
        ['group' => 'Role', 'name' => 'view-role-list', 'display_name' => 'View Role List', 'description' => ''],
        ['group' => 'Role', 'name' => 'create-role', 'display_name' => 'Create Role', 'description' => ''],
        ['group' => 'Role', 'name' => 'edit-role', 'display_name' => 'Edit Role', 'description' => ''],
        ['group' => 'Role', 'name' => 'delete-role', 'display_name' => 'Delete Role', 'description' => ''],
    ]);

    public function run()
    {
        foreach ($this->permissions as $permission) {
            PermissionsModel::updateOrCreate(['name' => $permission['name']],$permission);
        }
    }
}
