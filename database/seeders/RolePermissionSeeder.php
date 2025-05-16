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

        // Commond for sync permission
        // php artisan permissions:sync-to-seeder

        // Create Permissions
        $defaultPermissions = [
            'brand create',
            'brand delete',
            'brand edit',
            'brand list',
            'category create',
            'category delete',
            'category edit',
            'category list',
            'file create',
            'file delete',
            'file edit',
            'file list',
            'item type create',
            'item type delete',
            'item type edit',
            'item type list',
            'masters',
            'menu create',
            'menu delete',
            'menu edit',
            'menu list',
            'permission create',
            'permission delete',
            'permission edit',
            'permission list',
            'product create',
            'product delete',
            'product edit',
            'product list',
            'product review',
            'role create',
            'role delete',
            'role edit',
            'role list',
            'settings',
            'site settings',
            'subcategory create',
            'subcategory delete',
            'subcategory edit',
            'subcategory list',
            'user create',
            'user delete',
            'user edit',
            'user list',
        ];

        $permissionsList = [];
        foreach ($defaultPermissions as $permission) {
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
