<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{

    public function run()
    {

        $admin  = Role::firstOrCreate(['name' => 'Admin']);
        $author = Role::firstOrCreate(['name' => 'Author']);
        $user   = Role::firstOrCreate(['name' => 'User']);

        // Create Permissions
        $permissions = [
            'role list',
            'role create',
            'role edit',
            'role delete',
            'permission list',
            'permission create',
            'permission edit',
            'permission delete',
        ];

        $permissionsList = [];
        foreach ($permissions as $permission) {
            $permissionsList[$permission] = Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign Permissions to Roles
        $admin->permissions()->sync([
            $permissionsList['role list']->id,
            $permissionsList['role create']->id,
            $permissionsList['role edit']->id,
            $permissionsList['role delete']->id,
            $permissionsList['permission list']->id,
            $permissionsList['permission create']->id,
            $permissionsList['permission edit']->id,
            $permissionsList['permission delete']->id,
        ]);

        $author->permissions()->sync([
            $permissionsList['role list']->id,
            $permissionsList['role create']->id,
            $permissionsList['role edit']->id,
            $permissionsList['role delete']->id,
            $permissionsList['permission list']->id,
            $permissionsList['permission create']->id,
            $permissionsList['permission edit']->id,
            $permissionsList['permission delete']->id,
        ]);

        $user->permissions()->sync([
            $permissionsList['role list']->id,
            $permissionsList['role create']->id,
            $permissionsList['role edit']->id,
            $permissionsList['role delete']->id,
            $permissionsList['permission list']->id,
            $permissionsList['permission create']->id,
            $permissionsList['permission edit']->id,
            $permissionsList['permission delete']->id,
        ]);
    }
}
