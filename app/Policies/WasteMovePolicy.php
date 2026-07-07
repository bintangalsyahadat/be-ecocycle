<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\WasteMove;
use Illuminate\Auth\Access\HandlesAuthorization;

class WasteMovePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:WasteMove');
    }

    public function view(AuthUser $authUser, WasteMove $wasteMove): bool
    {
        return $authUser->can('View:WasteMove');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:WasteMove');
    }

    public function update(AuthUser $authUser, WasteMove $wasteMove): bool
    {
        return $authUser->can('Update:WasteMove');
    }

    public function delete(AuthUser $authUser, WasteMove $wasteMove): bool
    {
        return $authUser->can('Delete:WasteMove');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:WasteMove');
    }

    public function restore(AuthUser $authUser, WasteMove $wasteMove): bool
    {
        return $authUser->can('Restore:WasteMove');
    }

    public function forceDelete(AuthUser $authUser, WasteMove $wasteMove): bool
    {
        return $authUser->can('ForceDelete:WasteMove');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:WasteMove');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:WasteMove');
    }

    public function replicate(AuthUser $authUser, WasteMove $wasteMove): bool
    {
        return $authUser->can('Replicate:WasteMove');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:WasteMove');
    }

}