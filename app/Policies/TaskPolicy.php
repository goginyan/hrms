<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Task;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any tasks.
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
     * Determine whether the user can view any tasks.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function indexAll(User $user)
    {
        return $user->can('view all tasks');
    }

    /**
     * Determine whether the user can create tasks.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return !$user->isAdmin();
    }

    /**
     * Determine whether the user can update the task.
     *
     * @param User $user
     * @param Task $task
     *
     * @return mixed
     */
    public function update(User $user, Task $task)
    {
        if ($user->isAdmin()) {
            return true;
        }
        $allowedIds = array_merge(
            [
                $task->author->id,
                $task->responsible->id
            ],
            $task->assignee->getMorphClass() == 'team'
                ? $task->assignee->members->modelKeys()
                : [$task->assignee->id]
        );

        return in_array($user->employee->id, $allowedIds);
    }

    /**
     * Determine whether the user can delete the task.
     *
     * @param User $user
     * @param Task $task
     *
     * @return mixed
     */
    public function delete(User $user, Task $task)
    {
        return $user->isAdmin() || $task->author->id == $user->employee->id || $task->responsible->id == $user->employee->id;
    }

    /**
     * Determine whether the user can restore the task.
     *
     * @param User $user
     * @param Task $task
     *
     * @return mixed
     */
    public function restore(User $user, Task $task)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the task.
     *
     * @param User $user
     * @param Task $task
     *
     * @return mixed
     */
    public function forceDelete(User $user, Task $task)
    {
        return $user->isAdmin();
    }
}
