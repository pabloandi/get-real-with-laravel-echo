<?php

namespace App\Broadcasting;

use App\Models\Project;
use App\Models\User;

class TaskChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\Models\User  $user
     * @return array|bool
     */
    public function join(User $user, Project $project)
    {
        return $project->participants->contains($user);
    }
}
