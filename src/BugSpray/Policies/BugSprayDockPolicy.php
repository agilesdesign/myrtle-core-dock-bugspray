<?php

namespace Myrtle\Core\BugSpray\Policies;

use App\User;
use Myrtle\Docks\BugsprayDock;
use Illuminate\Auth\Access\HandlesAuthorization;

class BugSprayDockPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user has access to Addresses Dock Administrative Routes
     *
     * @param  \App\User $user
     * @return bool
     */
    public function accessAdmin(User $user)
    {
        return $user->allPermissions->contains(function ($ability) use ($user) {
            return $ability->name === BugsprayDock::class . '.access-admin';
        });
    }

    /**
     * Determine if the user has Administrator privileges
     *
     * @param  \App\User $user
     * @return bool
     */
    public function admin(User $user)
    {
        return $user->allPermissions->contains(function ($ability) {
            return $ability->name === BugsprayDock::class . '.admin';
        });
    }

    /**
     * Determine if the user can edit Dock Settings
     *
     * @param  \App\User $user
     * @return bool
     */
    public function editSettings(User $user)
    {
        return $user->allPermissions->contains(function ($ability) {
            return $ability->name === BugsprayDock::class . '.edit-settings';
        });
    }

    /**
     * Determine if the user can view Dock Settings
     *
     * @param  \App\User $user
     * @return bool
     */
    public function viewSettings(User $user)
    {
        return $user->allPermissions->contains(function ($ability) {
            return $ability->name === BugsprayDock::class . '.view';
        });
    }

    /**
     * Determine if the user can edit Dock Permissions
     *
     * @param  \App\User $user
     * @return bool
     */
    public function editPermissions(User $user)
    {
        return $user->allPermissions->contains(function ($ability) {
            return $ability->name === BugsprayDock::class . '.edit-settings';
        });
    }

    /**
     * Determine if the user can view Dock Permissions
     *
     * @param  \App\User $user
     * @return bool
     */
    public function viewPermissions(User $user)
    {
        return $user->allPermissions->contains(function ($ability) {
            return $ability->name === BugsprayDock::class . '.view';
        });
    }
}
