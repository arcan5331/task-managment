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

    static public function deleteTask(Task $task)
    {
        $task->delete();
    }

    static public function updateTask(Task $task, array $newData)
    {
        $task->update($newData);
    }

    static public function toggleTaskStatus(Task $task)
    {
        $task->toggleCompletionStatus();
    }

}
