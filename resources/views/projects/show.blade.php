<x-layout>
    <h1 class="title">{{ $project->name }}</h1>
    <task-list :project="{{ json_encode($project) }}"></task-list>
</x-layout>
