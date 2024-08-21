<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\TaskService;

class TaskList extends Component
{
    public $tasks;

    public function mount()
    {
        $this->refreshTask();
    }

    public function getListeners()
    {
        return [
            'echo-private:user.' . \auth()->id() . ',.task-created' => 'refreshTask',
            'echo-private:user.' . \auth()->id() . ',.task-updated' => 'refreshTask',
            'echo-private:user.' . \auth()->id() . ',.task-deleted' => 'refreshTask',
            'taskDeleted' => 'refreshTask',
            'taskCreated' => 'refreshTask',
            'taskUpdated' => 'refreshTask',
        ];
    }

    public function refreshTask()
    {
        $this->tasks = Task::where('user_id', Auth::id())->get();
    }

    public function toggleCompletion($taskId)
    {
        $task = Task::find($taskId);
        TaskService::toggleTaskStatus($task);
        $this->dispatch('taskUpdated');
        $this->refreshTask();
    }

    public function render()
    {
        return view('livewire.task-list');
    }
}
