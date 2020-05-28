<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Team;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any teams.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the team.
     *
     * @param User $user
     * @param Team $team
     *
     * @return mixed
     */
    public function view(User $user, Team $team)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $team->members->contains($user->employee);
    }

    /**
     * Determine whether the user can create teams.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('create teams');
    }

    /**
     * Determine whether the user can update the team.
     *
     * @param User $user
     * @param Team $team
     *
     * @return mixed
     */
    public function update(User $user, Team $team)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $team->leaders->contains($user->employee) || $team->admins->contains($user->employee);
    }

    /**
     * Determine whether the user can delete the team.
     *
     * @param User $user
     * @param Team $team
     *
     * @return mixed
     */
    public function delete(User $user, Team $team)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $team->admins->contains($user->employee);
    }

    /**
     * Determine whether the user can restore the team.
     *
     * @param User $user
     * @param Team $team
     *
     * @return mixed
     */
    public function restore(User $user, Team $team)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the team.
     *
     * @param User $user
     * @param Team $team
     *
     * @return mixed
     */
    public function forceDelete(User $user, Team $team)
    {
        return $user->isAdmin();
    }
}
