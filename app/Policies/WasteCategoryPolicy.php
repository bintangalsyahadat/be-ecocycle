<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\WasteCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class WasteCategoryPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:WasteCategory');
    }

    public function view(AuthUser $authUser, WasteCategory $wasteCategory): bool
    {
        return $authUser->can('View:WasteCategory');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:WasteCategory');
    }

    public function update(AuthUser $authUser, WasteCategory $wasteCategory): bool
    {
        return $authUser->can('Update:WasteCategory');
    }

    public function delete(AuthUser $authUser, WasteCategory $wasteCategory): bool
    {
        return $authUser->can('Delete:WasteCategory');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:WasteCategory');
    }

    public function restore(AuthUser $authUser, WasteCategory $wasteCategory): bool
    {
        return $authUser->can('Restore:WasteCategory');
    }

    public function forceDelete(AuthUser $authUser, WasteCategory $wasteCategory): bool
    {
        return $authUser->can('ForceDelete:WasteCategory');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:WasteCategory');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:WasteCategory');
    }

    public function replicate(AuthUser $authUser, WasteCategory $wasteCategory): bool
    {
        return $authUser->can('Replicate:WasteCategory');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:WasteCategory');
    }

}