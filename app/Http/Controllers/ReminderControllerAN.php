<?php

namespace App\Http\Controllers;

use App\Models\TaskAKL;
use App\Notifications\TaskDeadlineReminderAN;
use Illuminate\Support\Facades\Log;

class ReminderControllerAN extends Controller
{
    public function show()
    {
        return view('reminders.send');
    }

    public function send()
    {
        $tasks = TaskAKL::with('assignee')
            ->whereHas('assignee', fn ($query) => $query
                ->where('deadline_reminder_emails', true)
                ->whereNotNull('email')
            )
            ->whereNull('reminder_sent_at')
            ->whereIn('status', ['pending', 'in_progress'])
            ->whereBetween('deadline', [today()->toDateString(), today()->addDays(2)->toDateString()])
            ->get();

        if ($tasks->isEmpty()) {
            return back()->with('status', 'No deadline reminders were sent. Either there are no assigned tasks due in the next two days, or the assignee has reminders disabled.');
        }

        $errors = [];

        foreach ($tasks as $task) {
            try {
                $task->assignee->notify(new TaskDeadlineReminderAN($task));
                $task->forceFill(['reminder_sent_at' => now()])->save();
            } catch (\Throwable $exception) {
                Log::error('Failed to send deadline reminder for task ' . $task->id . ': ' . $exception->getMessage(), [
                    'task_id' => $task->id,
                    'assignee_id' => $task->assigned_to,
                ]);
                $errors[] = $exception->getMessage();
            }
        }

        $message = "Reminder emails were sent for {$tasks->count()} deadline reminder task(s).";

        if (! empty($errors)) {
            $message .= ' Some emails could not be delivered; check mail configuration.';
        }

        return back()->with('status', $message);
    }
}

