<?php

namespace App\Events;

use App\Events\TaskEvent as BaseTaskEvent;
use App\Models\Task;

class TaskUpdatedEvent extends BaseTaskEvent
{
    public function broadcastWith(): array
    {
        return [
            'type' => 'task_updated',
            'task' => $this->taskData
        ];
    }
}
