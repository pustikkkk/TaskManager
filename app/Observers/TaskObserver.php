<?php

namespace App\Observers;

use App\Models\Task;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
Log::info('OBSERVER FIRED', ['task' => $task->id]);
        $url = config('services.make_webhook_url');
        if(!$url) {
            return;
        }
        try {
            Http::timeout(5)->post($url, [
                'event' => 'task.created',
                'task_id' => $task->id,
            ]);
        } catch(\Throwable $e) {
            Log::warning('Make webhook failed', ['task' => $task->id, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }
}
