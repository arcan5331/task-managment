<?php

namespace App\Http\Services;

use App\Models\Task;
use Illuminate\Support\Facades\Log;

class TaskService
{
    static public function createTask(array $taskData)
    {
        Log::notice('user with id {authId} created a task for user {taskedId} with this title: {title}',
            ['authId' => auth()->id(), 'taskedId' => $taskData['user_id'], 'title' => $taskData['titles']]);
        return Task::create($taskData);
    }

    static public function deleteTask(Task $task)
    {
        Log::warning('user with id {authId} deleted a task with id {taskId} with title: {title}',
            ['authId' => auth()->id(), 'taskId' => $task->id, 'title' => $task->title]);
        $task->delete();
    }

    static public function updateTask(Task $task, array $newData)
    {
        Log::warning('user with id {authId} updated a task with id {taskId} with title: {title}',
            ['authId' => auth()->id(), 'taskId' => $task->id, 'title' => $task->title]);
        $task->update($newData);
    }

    static public function toggleTaskStatus(Task $task)
    {
        Log::warning('user with id {authId} toggled task status with id {taskId} with title: {title}',
            ['authId' => auth()->id(), 'taskId' => $task->id, 'title' => $task->title]);
        $task->toggleCompletionStatus();
    }

}
