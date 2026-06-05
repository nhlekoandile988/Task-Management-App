<?php

namespace App\Console\Commands;

use App\Models\TaskAKL;
use App\Notifications\TaskDeadlineReminderAN;
use Illuminate\Console\Command;

class SendDeadlineRemindersAN extends Command
{
    protected $signature = 'smartdrive:send-deadline-reminders {--days=2 : Number of days ahead to check}';

    protected $description = 'Send email deadline reminders for Smart Drive tasks that are due soon.';

    public function handle()
    {
        $days = (int) $this->option('days');

        $tasks = TaskAKL::with('assignee')
            ->whereNotNull('assigned_to')
            ->whereNull('reminder_sent_at')
            ->whereIn('status', ['pending', 'in_progress'])
            ->whereBetween('deadline', [today()->toDateString(), today()->addDays($days)->toDateString()])
            ->get();

        foreach ($tasks as $task) {
            $task->assignee->notify(new TaskDeadlineReminderAN($task));
            $task->forceFill(['reminder_sent_at' => now()])->save();
        }

        $this->info("Sent {$tasks->count()} deadline reminder(s).");

        return self::SUCCESS;
    }
}

