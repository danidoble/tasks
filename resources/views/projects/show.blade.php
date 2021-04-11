<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $project->name }}
        </h2>
    </x-slot>

    <div class="pb-12 pt-4">
        <div class="max-w-7xl mx-auto">
            @livewire('tasks.store',['idx'=>$project->id])

            @livewire('tasks.index',['idx'=>$project->id])

            <input type="hidden" id="id_project_always" value="{{ $project->id }}">
            <input type="hidden" id="id_task_selected" value="">
        </div>
    </div>
</x-app-layout>
