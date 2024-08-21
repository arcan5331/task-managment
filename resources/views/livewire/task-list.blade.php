<div class="max-w-xl mx-auto mt-8">
    <ul class="bg-white shadow-md rounded-lg divide-y divide-gray-200">
        @foreach($tasks as $task)
            <li class="py-4 px-6 flex justify-between items-center
                {{ $task->status === \App\Enums\TaskStatus::completed->value ? 'bg-green-100' : '' }}
                {{ $task->status === \App\Enums\TaskStatus::overDu->value ? 'bg-red-100' : 'bg-white' }}">
                <div class="flex items-center">

                    <input id="status_checkbox" type="checkbox" wire:click="toggleCompletion({{ $task->id }})"
                           wire:model.defer="tasks.{{ $loop->index }}.status"
                           {{ $task->status === \App\Enums\TaskStatus::completed->value ? 'checked' : '' }}
                           class="mr-4 h-5 w-5 text-green-600 border-gray-300 rounded focus:ring-green-500
                           {{ $task->status === \App\Enums\TaskStatus::overDu->value ? 'bg-red-500' : '' }}">
                    @if(!$task->status === \App\Enums\TaskStatus::completed->value)
                        <script>
                            document.getElementById('status_checkbox').removeAttribute('checked');
                        </script>
                    @endif
                    <div>
                        <span
                            class="text-lg font-semibold
                            {{ $task->status === \App\Enums\TaskStatus::completed->value ? 'line-through text-gray-500' : '' }}">
                            {{ $task->title }}
                        </span>
                        <p class="text-sm text-gray-600">{{ $task->description }}</p>

                        <div class="text-xs text-gray-500 mt-2">
                            <span class="mr-2">
                                <strong>Superiority:</strong>
                                <span
                                    class="
                                    {{ $task->superiority === \App\Enums\TaskSuperiority::critical->value ? 'text-red-500' :
                                        ($task->superiority === \App\Enums\TaskSuperiority::normal->value ?
                                        'text-yellow-500' : 'text-green-500') }}">
                                    {{ $task->superiority }}
                                </span>
                            </span>
                            <span class="mr-2">
                                <strong>Due Date:</strong> {{ $task->du_date }}
                            </span>
                            <span class="mr-2">
                                <strong>Status:</strong>
                                <span
                                    class="{{ $task->status === \App\Enums\TaskStatus::completed->value ?
                                        'text-green-500' : ($task->status === \App\Enums\TaskStatus::overDu->value ? 'text-red-500' :
                                        'text-yellow-500') }}">
                                    {{ $task->status }}
                                </span>
                            </span>
                            <span>
                                <strong>User ID:</strong> {{ $task->user_id }}
                            </span>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
