<?php

namespace App\Policies;

use App\Models\TaskAKL;
use App\Models\User;

class TaskPolicyAKL
{
    public function viewAny(User $user)
    {
        return in_array($user->role, ['admin', 'team_member', 'guest']);
    }

    public function view(User $user, TaskAKL $task)
    {
        return $user->isAdmin() || $task->assigned_to === $user->id || $task->created_by === $user->id;
    }

    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'team_member']);
    }

    public function update(User $user, TaskAKL $task)
    {
        return $user->isAdmin() || $task->assigned_to === $user->id || $task->created_by === $user->id;
    }

    public function delete(User $user, TaskAKL $task)
    {
        return $user->isAdmin() || $task->created_by === $user->id;
    }
}

