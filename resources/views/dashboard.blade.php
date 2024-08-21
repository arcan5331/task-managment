<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Dashboard</h1>

        @if(auth()->user()->isAdmin())
            <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                <h2 class="text-xl font-semibold mb-2">Admin Task Manager</h2>
                @livewire('task-manager')
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-xl font-semibold mb-2">Your Tasks</h2>
            @livewire('task-list')
        </div>
    </div>

    @livewireScripts
</x-app-layout>
