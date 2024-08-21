<?php

namespace App\Observers;

use App\Models\Task;

class TaskObserver
{
    public function created(Task $task): void
    {
    }

    public function updated(Task $task): void
    {
    }

    public function deleted(Task $task): void
    {
    }
}
