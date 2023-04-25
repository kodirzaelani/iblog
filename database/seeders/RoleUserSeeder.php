<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //assign permission to role
        $role = Role::find('392fac7a-dc65-44cd-b07b-03f1cc0d3a62');
        $permissions = Permission::all();

        $role->syncPermissions($permissions);

        //assign role with permission to user
        $user = User::find('b332722d-98c5-442c-890d-cc3345346a19');
        $user->assignRole($role->name);
    }
}
