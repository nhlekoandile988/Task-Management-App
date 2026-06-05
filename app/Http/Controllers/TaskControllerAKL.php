<?php

namespace App\Http\Controllers;

use App\Models\CategoryAKL;
use App\Models\TaskAKL;
use App\Models\User;
use App\Rules\DeadlineAfterTodayAN;
use Illuminate\Http\Request;

class TaskControllerAKL extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', TaskAKL::class);

        $categories = CategoryAKL::orderBy('name')->get();

        $tasks = TaskAKL::with(['category', 'assignee'])
            ->forUser($request->user())
            ->when($request->filled('search'), fn ($query) => $query->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                      ->orWhere('description', 'like', '%' . $request->search . '%');
            }))
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', $request->category_id))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->when($request->filled('priority'), fn ($query) => $query->where('priority', $request->priority))
            ->when($request->filled('sort'), function ($query) use ($request) {
                return match ($request->sort) {
                    'oldest' => $query->oldest('created_at'),
                    'deadline_asc' => $query->orderBy('deadline', 'asc'),
                    'deadline_desc' => $query->orderBy('deadline', 'desc'),
                    default => $query->latest(),
                };
            })
            ->paginate(10)
            ->withQueryString();

        return view('tasks.index', compact('tasks', 'categories'));
    }

    public function create()
    {
        $this->authorize('create', TaskAKL::class);

        return view('tasks.create', $this->formData());
    }

    public function store(Request $request)
    {
        $this->authorize('create', TaskAKL::class);

        $data = $this->validatedData($request);
        $data['created_by'] = $request->user()->id;

        $task = TaskAKL::create($data);

        return redirect()->route('tasks.confirmation', $task);
    }

    public function confirmation(TaskAKL $task)
    {
        $this->authorize('view', $task);

        return view('tasks.confirmation', compact('task'));
    }

    public function show(TaskAKL $task)
    {
        $this->authorize('view', $task);

        return view('tasks.show', compact('task'));
    }

    public function edit(TaskAKL $task)
    {
        $this->authorize('update', $task);

        return view('tasks.edit', array_merge($this->formData(), compact('task')));
    }

    public function update(Request $request, TaskAKL $task)
    {
        $this->authorize('update', $task);

        $task->update($this->validatedData($request));

        return redirect()->route('tasks.show', $task)->with('status', 'Task updated successfully.');
    }

    public function destroy(TaskAKL $task)
    {
        $this->authorize('delete', $task);
        $task->delete();

        return redirect()->route('tasks.index')->with('status', 'Task deleted successfully.');
    }

    public function assigned(Request $request)
    {
        $this->authorize('viewAny', TaskAKL::class);

        $categories = CategoryAKL::orderBy('name')->get();

        $tasks = TaskAKL::with(['category', 'assignee'])
            ->where('assigned_to', $request->user()->id)
            ->when($request->filled('search'), fn ($query) => $query->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                      ->orWhere('description', 'like', '%' . $request->search . '%');
            }))
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', $request->category_id))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->when($request->filled('priority'), fn ($query) => $query->where('priority', $request->priority))
            ->when($request->filled('sort'), function ($query) use ($request) {
                return match ($request->sort) {
                    'oldest' => $query->oldest('created_at'),
                    'deadline_asc' => $query->orderBy('deadline', 'asc'),
                    'deadline_desc' => $query->orderBy('deadline', 'desc'),
                    default => $query->latest(),
                };
            })
            ->paginate(10)
            ->withQueryString();

        return view('tasks.assigned', compact('tasks', 'categories'));
    }

    private function validatedData(Request $request)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'title' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string'],
            'tags' => ['nullable', 'string', 'max:255'],
            'priority' => ['required', 'in:low,medium,high'],
            'status' => ['required', 'in:pending,in_progress,completed'],
            'deadline' => ['nullable', 'date', new DeadlineAfterTodayAN],
        ], [
            'category_id.required' => 'Please choose a task category.',
            'title.required' => 'Every task needs a clear title.',
        ]);

        $data['tags'] = $this->formatTags($data['tags'] ?? null);

        return $data;
    }

    private function formatTags(?string $tags): ?array
    {
        if (! $tags) {
            return null;
        }

        $cleaned = array_filter(array_map('trim', explode(',', $tags)));

        return count($cleaned) ? array_values($cleaned) : null;
    }

    private function formData()
    {
        return [
            'categories' => CategoryAKL::orderBy('name')->get(),
            'users' => User::whereIn('role', ['admin', 'team_member'])->orderBy('name')->get(),
        ];
    }
}

