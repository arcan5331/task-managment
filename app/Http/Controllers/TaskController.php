<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskCreateRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Services\TaskService;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->isAdmin()) {
            $tasks = Task::all();
        } else {
            $this->authorize('viewSelf', Task::class);
            $tasks = $request->user()->tasks;
        }
        Log::info('user with id {authId} viewed {taskCount} tasks',
            ['authId' => auth()->id(), 'taskCount' => count($tasks)]);

        return $tasks;
    }

    public function store(TaskCreateRequest $request)
    {
        if (!((int)$request->input('user_id') === auth()->id())) {
            $this->authorize('createForAllUsers', Task::class);
        } else {
            $this->authorize('createForSelf', Task::class);
        }
        return TaskService::createTask($request->validated())->refresh();

    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);
        Log::info('user with id {authId} viewed task with id {taskId}',
            ['authId' => auth()->id(), 'taskId' => $task->id]);
        return $task;
    }

    public function update(TaskUpdateRequest $request, Task $task)
    {
        $this->authorize('update', $task);
        TaskService::updateTask($task, $request->validated());
        return $task->refresh();
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        TaskService::deleteTask($task);
        return response()->noContent();
    }

    public function toggleTaskStatus(Task $task)
    {
        $this->authorize('toggleTaskStatus', $task);
        TaskService::toggleTaskStatus($task);
        return $task->refresh();
    }
}
