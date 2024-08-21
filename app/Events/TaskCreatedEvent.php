<?php

namespace App\Events;

use App\Events\TaskEvent as BaseTaskEvent;

class TaskCreatedEvent extends BaseTaskEvent
{
    public function broadcastWith(): array
    {
        return [
            'type' => 'task_created',
            'task' => $this->task
        ];
    }
}
