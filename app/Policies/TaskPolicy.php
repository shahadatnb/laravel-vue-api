<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function create(User $user, $project_id)
    {
        //
        $project = Project::findOrFail($project_id);
        return $user->id === $project->user_id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Task  $task
     * @return mixed
     */
    public function update(User $user, Task $task)
    {
        //
        return $user->id === $task->project->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Task  $task
     * @return mixed
     */
    public function delete(User $user, Task $task)
    {
        //
        return $user->id === $task->project->user_id;
    }
}
