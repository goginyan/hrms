<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TimeOff;
use Illuminate\Auth\Access\HandlesAuthorization;

class TimeOffPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any time offs.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return !$user->isAdmin();
    }

    /**
     * Determine whether the user can manage the time offs.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     * @throws \Exception
     */
    public function manage(User $user)
    {
        return $user->hasAllPermissions(['delete time-offs', 'approve time-offs']);
    }

    /**
     * Determine whether the user can create time offs.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return !$user->isAdmin();
    }

    /**
     * Determine whether the user can update the time off settings.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     * @throws \Exception
     */
    public function update(User $user)
    {
        return $user->hasAllPermissions(['delete time-offs', 'approve time-offs']);
    }

    /**
     * Determine whether the user can approve the time off.
     *
     * @param \App\Models\User    $user
     * @param \App\Models\TimeOff $timeOff
     *
     * @return mixed
     */
    public function approve(User $user, TimeOff $timeOff)
    {
        return $user->can('approve time-offs');
    }

    /**
     * Determine whether the user can delete the time off.
     *
     * @param \App\Models\User    $user
     * @param \App\Models\TimeOff $timeOff
     *
     * @return mixed
     */
    public function delete(User $user, TimeOff $timeOff)
    {
        return $user->can('delete time-offs');
    }
}
