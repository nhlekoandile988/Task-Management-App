<?php

namespace App\Observers;

use App\Models\TaskAKL;

class TaskObserverAN
{
    public function creating(TaskAKL $task)
    {
        if (!$task->status) {
            $task->status = 'pending';
        }

        if (!$task->priority) {
            $task->priority = 'medium';
        }
    }
}

