<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Call Role-Permission Seeder First
        $this->call(RolePermissionSeeder::class);

        // Fetch Roles (Make Sure They Exist)
        $adminRole = Role::where('name', 'Admin')->first();
        $authorRole = Role::where('name', 'Author')->first();
        $userRole = Role::where('name', 'User')->first();

        // Insert Users with Roles
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );
        $admin->roles()->attach($adminRole->id);

        $author = User::firstOrCreate(
            ['email' => 'author@gmail.com'],
            [
                'name' => 'Author',
                'password' => Hash::make('password'),
            ]
        );
        $author->roles()->attach($authorRole->id);

        $user = User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'User',
                'password' => Hash::make('password'),
            ]
        );
        $user->roles()->attach($userRole->id);
    }
}
