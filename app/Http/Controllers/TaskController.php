<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->isAdmin()) {
            return Task::all();
        }
        $this->authorize('viewSelf');
        return $request->user()->tasks();
    }

    public function store(Request $request)
    {

    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);
        return $task;
    }

    public function update(Request $request, Task $task)
    {

    }

    public function destroy(Task $task)
    {

    }
}
