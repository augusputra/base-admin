<?php

use Illuminate\Database\Seeder;
use App\Models\RolePermissionsModel;
use App\Models\PermissionsModel;
use App\Models\RolesModel;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = PermissionsModel::all();
        $admin_role = RolesModel::where('name', 'admin')->first();
        
        if(empty($admin_role)){
            $admin_role = RolesModel::create([
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Administrator',
            ]);
        }
        $role_id = $admin_role->id;
        foreach ($permissions as $permission) {
            RolePermissionsModel::Create([
                'role_id' => $role_id,
                'permission_id' => $permission['id']
            ]);
        }
    }
}
