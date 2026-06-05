<?php

namespace App\Http\Controllers;

use App\Models\CategoryAKL;
use App\Models\TaskAKL;

class DashboardControllerAN extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();
        $tasks = TaskAKL::with(['category', 'assignee'])->forUser($user)->latest()->get();

        return view('dashboard', [
            'totalTasks' => $tasks->count(),
            'openTasks' => $tasks->whereIn('status', ['pending', 'in_progress'])->count(),
            'completedTasks' => $tasks->where('status', 'completed')->count(),
            'dueSoonTasks' => $tasks->filter(fn ($task) => $task->deadline && $task->deadline->between(today(), today()->addDays(3)))->count(),
            'recentTasks' => $tasks->take(6),
            'categories' => CategoryAKL::withCount('tasks')->get(),
        ]);
    }
}

