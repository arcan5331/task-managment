<?php

namespace App\Livewire;

use App\Http\Requests\TaskCreateRequest;
use App\Rules\JalaliDate;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Task;
use App\Models\User;
use App\Enums\TaskStatus;
use App\Enums\TaskSuperiority;
use App\Http\Services\TaskService;
use Morilog\Jalali\Jalalian;

class TaskManager extends Component
{
    public
        $userId,
        $tasks,
        $users,
        $user_id,
        $title,
        $description,
        $superiority,
        $du_date,
        $du_dateG,
        $status,
        $editingTaskId = null;  // New property to track the task being edited

    public function mount()
    {
        $this->userId = auth()->id();
        $this->tasks = Task::all();
        $this->users = User::all();
        $this->du_date = jdate()->format('Y/m/d');
        $this->setDuDateG();
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'min:2'],
            'du_date' => ['required', new JalaliDate()],
            'description' => ['nullable', 'min:2'],
            'superiority' => ['nullable', Rule::enum(TaskSuperiority::class)],
            'status' => ['nullable', Rule::enum(TaskStatus::class)],
        ];
    }

    public function getListeners()
    {
        return [
            'echo-private:Admin,.task-created' => 'refreshTask',
            'echo-private:Admin,.task-updated' => 'refreshTask',
            'echo-private:Admin,.task-deleted' => 'refreshTask',
            'taskDeleted' => 'refreshTask',
            'taskCreated' => 'refreshTask',
            'taskUpdated' => 'refreshTask',
        ];
    }

    public function createTask()
    {
        $this->validate();

        if ($this->editingTaskId) {
            $task = Task::find($this->editingTaskId);
            TaskService::updateTask($task, [
                'title' => $this->title,
                'description' => $this->description,
                'user_id' => $this->user_id,
                'superiority' => $this->superiority,
                'du_date' => $this->du_date,
                'status' => $this->status,
            ]);
            $this->dispatch('taskUpdated');
        } else {
            TaskService::createTask([
                'title' => $this->title,
                'description' => $this->description,
                'user_id' => $this->user_id,
                'superiority' => $this->superiority,
                'du_date' => $this->du_date,
                'status' => $this->status,
            ]);
            $this->dispatch('taskCreated');
        }

        $this->resetInputFields();
        $this->refreshTasks();
    }

    protected function setDuDateG()
    {
        $this->du_dateG = Jalalian::fromFormat('Y/m/d', $this->du_date)->toCarbon()->format('Y-m-d');
    }

    public function editTask($taskId)
    {
        $task = Task::find($taskId);
        $this->editingTaskId = $task->id;
        $this->user_id = $task->user_id;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->superiority = $task->superiority;
        $this->du_date = $task->du_date;
        $this->status = $task->status;
        $this->setDuDateG();
    }

    public function deleteTask($taskId)
    {
        $task = Task::find($taskId);
        TaskService::deleteTask($task);
        $this->dispatch('taskDeleted');
        $this->refreshTasks();
    }

    public function resetInputFields()
    {
        $this->editingTaskId = null;
        $this->user_id = '';
        $this->title = '';
        $this->description = '';
        $this->superiority = '';
        $this->du_date = jdate()->format('Y/m/d');
        $this->setDuDateG();
        $this->status = '';
    }

    public function refreshTasks()
    {
        $this->tasks = Task::all();
    }

    public function render()
    {
        return view('livewire.task-manager');
    }
}
