<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    public function givePermissionTo($permissions)
    {
        // Ensure $permissions is an array
        $permissions = is_array($permissions) ? $permissions : [$permissions];

        // Convert permission names to IDs
        $permissionIds = Permission::whereIn('name', $permissions)->pluck('id')->toArray();

        // Attach permissions by IDs
        $this->permissions()->sync($permissionIds);
    }
}
