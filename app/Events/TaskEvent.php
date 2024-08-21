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
    public array $taskData;

    public function __construct(array $taskData)
    {
        $this->superiority = $taskData['superiority'];
        $this->taskId = $taskData['id'];
        $this->taskData = $taskData;
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

    public function broadcastOn()
    {
        return [
            new PrivateChannel('Admin'),
            new PrivateChannel('user.' . $this->taskData['user_id'])
        ];
    }
}

