<?php

namespace App\Events;

use App\Enums\TaskSuperiority;
use App\Models\Task;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskCreatedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $superiority;

    public function __construct(Task $task)
    {
        $this->superiority = $task->superiority;
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

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name')
        ];
    }
}
