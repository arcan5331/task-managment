<?php

namespace App\Events;

use App\Events\TaskEvent as BaseTaskEvent;

class TaskDeletedEvent extends BaseTaskEvent
{
    public function broadcastWith(): array
    {
        return [
            'type' => 'task_deleted',
            'task' => $this->taskData
        ];
    }
}
