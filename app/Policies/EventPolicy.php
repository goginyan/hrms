<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any events.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return !$user->isAdmin();
    }

    /**
     * Determine whether the user can view the event.
     *
     * @param User  $user
     * @param Event $event
     *
     * @return mixed
     */
    public function view(User $user, Event $event)
    {
        return $user->isAdmin() || $user->employee->id == $event->creator_id || $event->members->contains($user->employee);
    }

    /**
     * Determine whether the user can create events.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the event.
     *
     * @param User  $user
     * @param Event $event
     *
     * @return mixed
     */
    public function update(User $user, Event $event)
    {
        return $user->isAdmin() || $user->employee->id == $event->creator_id;
    }

    /**
     * Determine whether the user can delete the event.
     *
     * @param User  $user
     * @param Event $event
     *
     * @return mixed
     */
    public function delete(User $user, Event $event)
    {
        return $user->isAdmin() || $user->employee->id == $event->creator_id;
    }

    /**
     * Determine whether the user can restore the event.
     *
     * @param User  $user
     * @param Event $event
     *
     * @return mixed
     */
    public function restore(User $user, Event $event)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the event.
     *
     * @param User  $user
     * @param Event $event
     *
     * @return mixed
     */
    public function forceDelete(User $user, Event $event)
    {
        return $user->isAdmin();
    }
}
