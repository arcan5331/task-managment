<?php

namespace App\Http\Services;

use App\Models\Task;
use App\Models\User;

class TaskService
{
    static public function createTask(array $taskData)
    {
        return Task::create($taskData);
    }
}
