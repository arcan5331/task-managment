<?php

namespace App\Observers;

use App\Events\TaskCreatedEvent;
use App\Models\Task;

class TaskObserver
{
    public function created(Task $task): void
    {
        event(new TaskCreatedEvent($task->toArray()));
    }

    public function updated(Task $task): void
    {
    }

    public function deleted(Task $task): void
    {
    }
}
