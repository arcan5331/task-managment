<?php

namespace App\Observers;

use App\Events\TaskCreatedEvent;
use App\Events\TaskDeletedEvent;
use App\Events\TaskUpdatedEvent;
use App\Models\Task;

class TaskObserver
{
    public function created(Task $task): void
    {
        event(new TaskCreatedEvent($task->toArray()));
    }

    public function updated(Task $task): void
    {
        event(new TaskUpdatedEvent($task->toArray()));
    }

    public function deleting(Task $task): void
    {
        event(new TaskDeletedEvent($task->toArray()));
    }
}
