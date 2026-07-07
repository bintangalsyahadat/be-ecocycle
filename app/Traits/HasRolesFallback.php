<?php

namespace App\Traits;

/**
 * Fallback trait when spatie/laravel-permission is not installed.
 * Provides empty stub methods to prevent fatal errors during config cache.
 */
trait HasRolesFallback
{
    public function assignRole(...$parameters) {}
    public function removeRole(...$parameters) {}
    public function syncRoles(...$parameters) {}
    public function hasRole(...$parameters): bool { return false; }
    public function hasAnyRole(...$parameters): bool { return false; }
    public function hasAllRoles(...$parameters): bool { return false; }
    public function hasExactRoles(...$parameters): bool { return false; }
    public function getRoleNames(...$parameters) { return collect(); }
    public function roles(...$parameters) { return $this->belongsToMany(\App\Models\Role::class); }
    public function permissions(...$parameters) { return $this->belongsToMany(\App\Models\Permission::class); }
    public function hasPermissionTo(...$parameters): bool { return true; }
    public function hasAnyPermission(...$parameters): bool { return true; }
    public function getAllPermissions(...$parameters) { return collect(); }
    public function getDirectPermissions(...$parameters) { return collect(); }
    public function getPermissionsViaRoles(...$parameters) { return collect(); }
    public function hasDirectPermission(...$parameters): bool { return true; }
    public function hasPermissionViaRole(...$parameters): bool { return true; }
    public function scopePermission(...$parameters) { return $this; }
    public function scopeRole(...$parameters) { return $this; }
    public function getStoredRole(...$parameters) { return null; }
    public function getDefaultGuardName(...$parameters): string { return 'web'; }
}
