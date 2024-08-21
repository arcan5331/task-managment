<div class="max-w-xl mx-auto mt-8 bg-white p-6 shadow-md rounded-lg">
    <form wire:submit.prevent="createTask">
        <div class="mb-4">
            @if($editingTaskId)
                <label class="text-lg font-semibold text-blue-600">
                    Editing task {{$editingTaskId . ' ... ' . $title}}
                </label>
            @endif
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Select User
            </label>
            <select wire:model="user_id" class="border rounded p-2 w-full focus:ring-blue-500 focus:border-blue-500" required>
                <option value="" selected>Select User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            @error('selectedUser') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Task Title
            </label>
            <input type="text" wire:model="title" placeholder="Task Title"
                   class="border rounded p-2 w-full focus:ring-blue-500 focus:border-blue-500" required>
            @error('taskTitle') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Task Description
            </label>
            <input type="text" wire:model="description" placeholder="Task Description"
                   class="border rounded p-2 w-full focus:ring-blue-500 focus:border-blue-500">
            @error('taskDescription') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Task Superiority
            </label>
            <select wire:model="superiority" class="border rounded p-2 w-full focus:ring-blue-500 focus:border-blue-500" required>
                <option value="" selected>Choose Superiority</option>
                @foreach(\App\Enums\TaskSuperiority::cases() as $superiority)
                    <option value="{{ $superiority->value }}">{{ $superiority->value }}</option>
                @endforeach
            </select>
            @error('taskSuperiority') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Du Date
            </label>
            <div wire:target="editTask">
                <x-persian-datepicker
                    wirePropertyName="du_date"
                    label="Du Date"
                    showFormat="jYYYY/jMM/jDD"
                    returnFormat="jYYYY/jMM/jDD"
                    :required="true"
                    :defaultDate="$du_dateG"/>
            </div>
            @error('taskDueDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Task Status
            </label>
            <select wire:model="status" class="border rounded p-2 w-full focus:ring-blue-500 focus:border-blue-500" required>
                <option value="" selected>Choose Status</option>
                @foreach(\App\Enums\TaskStatus::cases() as $status)
                    <option value="{{ $status->value }}">{{ $status->value }}</option>
                @endforeach
            </select>
            @error('taskStatus') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="bg-blue-500 text-white rounded p-2 w-full hover:bg-blue-600">
            {{ $editingTaskId ? 'Update Task' : 'Create Task' }}
        </button>
    </form>

    <ul class="mt-8 bg-gray-50 shadow-md rounded-lg divide-y divide-gray-200">
        @foreach($tasks as $task)
            <li class="py-4 px-6 flex justify-between items-center
                {{ $task->status === \App\Enums\TaskStatus::completed->value ? 'bg-green-100' : '' }}
                {{ $task->status === \App\Enums\TaskStatus::overDu->value ? 'bg-red-100' : 'bg-white' }}">
                <div class="flex items-center">
                    <input type="checkbox"
                           {{ $task->status === \App\Enums\TaskStatus::completed->value ? 'checked' : '' }}
                           class="mr-4 h-5 w-5 text-green-600 border-gray-300 rounded focus:ring-green-500"
                           readonly disabled>

                    <span class="text-lg font-semibold {{ $task->status === \App\Enums\TaskStatus::completed->value ? 'line-through text-gray-500' : '' }}">
                        {{ $task->title }} - {{ $task->description }} - {{ $task->user->name }}
                    </span>
                </div>
                <div class="flex">
                    <button wire:click="editTask({{ $task->id }})" class="bg-yellow-500 text-white rounded p-2 mr-2 hover:bg-yellow-600">
                        Edit
                    </button>
                    <button wire:click="deleteTask({{ $task->id }})" class="bg-red-500 text-white rounded p-2 hover:bg-red-600">
                        Delete
                    </button>
                </div>
            </li>
        @endforeach
    </ul>
</div>
