<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskCreateRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Services\TaskService;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->isAdmin()) {
            return Task::all();
        }
        $this->authorize('viewSelf', Task::class);
        return $request->user()->tasks;
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

    }
}
