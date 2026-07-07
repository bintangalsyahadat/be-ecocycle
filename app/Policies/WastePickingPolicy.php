<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\WastePicking;
use Illuminate\Auth\Access\HandlesAuthorization;

class WastePickingPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:WastePicking');
    }

    public function view(AuthUser $authUser, WastePicking $wastePicking): bool
    {
        return $authUser->can('View:WastePicking');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:WastePicking');
    }

    public function update(AuthUser $authUser, WastePicking $wastePicking): bool
    {
        return $authUser->can('Update:WastePicking');
    }

    public function delete(AuthUser $authUser, WastePicking $wastePicking): bool
    {
        return $authUser->can('Delete:WastePicking');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:WastePicking');
    }

    public function restore(AuthUser $authUser, WastePicking $wastePicking): bool
    {
        return $authUser->can('Restore:WastePicking');
    }

    public function forceDelete(AuthUser $authUser, WastePicking $wastePicking): bool
    {
        return $authUser->can('ForceDelete:WastePicking');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:WastePicking');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:WastePicking');
    }

    public function replicate(AuthUser $authUser, WastePicking $wastePicking): bool
    {
        return $authUser->can('Replicate:WastePicking');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:WastePicking');
    }

}