<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Permission;

class SyncPermissionsToSeeder extends Command
{
    protected $signature = 'permissions:sync-to-seeder';
    protected $description = 'Sync all permissions into RolePermissionSeeder.php as a PHP array';

    public function handle()
    {
        $permissions = Permission::pluck('name')->toArray();

        $formatted = "\$defaultPermissions = [\n";
        foreach ($permissions as $perm) {
            $formatted .= "    '" . addslashes($perm) . "',\n";
        }
        $formatted .= "];";

        $seederPath = base_path('database/seeders/RolePermissionSeeder.php');
        $contents = file_get_contents($seederPath);

        // Replace the existing $defaultPermissions array with new one
        $pattern = '/\$defaultPermissions\s*=\s*\[[^\]]*\];/s';
        $newContents = preg_replace($pattern, $formatted, $contents);

        if ($newContents === null) {
            $this->error('Failed to update the seeder file. Check syntax.');
            return;
        }

        file_put_contents($seederPath, $newContents);
        $this->info('Permissions list synced to RolePermissionSeeder.php successfully.');
    }
}
