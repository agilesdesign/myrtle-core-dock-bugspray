<?php

namespace Myrtle\Core\BugSpray\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Myrtle\Docks\BugsprayDock;

class BugSprayPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function before(User $user)
    {
        if ($this->admin($user))
        {
            return true;
        }
    }

    public function admin(User $auth)
    {
        return $auth->allPermissions->contains(function ($ability, $key)
        {
            return $ability->name === BugsprayDock::class . '.admin';
        });
    }

    public function accessAdmin(User $auth)
    {
        return $auth->allPermissions->contains(function ($ability, $key) use ($auth)
        {
            return $ability->name === 'bugspray.access.admin';
        });
    }
}
