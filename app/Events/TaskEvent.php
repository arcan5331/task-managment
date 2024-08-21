<?php

namespace App\Events;

use App\Enums\TaskSuperiority;
use App\Models\Task;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $superiority;
    public int $taskId;

    public function __construct(public Task $task)
    {
        $this->superiority = $task->superiority;
        $this->taskId = $task->id;
    }

    public function broadcastQueue(): string
    {
        return match ($this->superiority) {
            TaskSuperiority::critical->value => 'high',
            TaskSuperiority::normal->value => 'medium',
            TaskSuperiority::insignificant->value => 'low',
            default => 'default'
        };
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('task.' . $this->task->id);
    }
}

