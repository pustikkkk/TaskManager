@php use Carbon\Carbon; @endphp
@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <h1 class="text-4xl font-bold m-4 text-center">Task Dashboard</h1>
    <ul class="space-y-4 px-6 max-w-3xl mx-auto pb-8">
        @forelse($tasks as $task)
            @if($task->status == 'pending')
                <li class="border border-white/20 rounded-3xl backdrop-blur-sm bg-white/10 shadow-lg hover:shadow-xl transition-all duration-300 p-6">
                    <strong class="text-xl font-bold">{{ $task->title }}</strong>

                    <div class="flex flex-wrap gap-x-6 gap-y-1 mt-2 text-sm opacity-75">
                        <span>Due: {{Carbon::parse($task->due_date)->format('M d, Y')}}</span>
                        <span>Priority: {{ ucfirst($task->priority) }}</span>
                        <span>Status: {{ $task->status }}</span>
                    </div>

                    <div class="flex flex-wrap gap-2 mt-4 items-center">
                        <a href="{{ route('tasks.edit',$task->id) }}" class="text-lg text-cyan-50/85 bg-white/5 backdrop-blur-2 px-3 py-1 rounded-3xl shadow-md
                            border border-white/20 transition-all duration-300
                            hover:text-indigo-200/85 hover:bg-white/5">Edit</a>
                        <a href="{{route('tasks.show',$task->id)}}" class="text-lg text-cyan-50/85 bg-white/5 backdrop-blur-2 px-3 py-1 rounded-3xl shadow-md
                            border border-white/20 transition-all duration-300
                            hover:text-indigo-200/85 hover:bg-white/5">View more</a>
                        <form action="{{ route('tasks.destroy',$task->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?')" class="contents">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-lg text-cyan-50/85 bg-white/5 backdrop-blur-2 px-3 py-1 rounded-3xl shadow-md
                                border border-white/20 transition-all duration-300
                                hover:text-indigo-200/85 hover:bg-white/5">Delete</button>
                        </form>
                        <form action="{{route('tasks.complete',$task->id)}}" method="POST" class="contents">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-lg text-cyan-50/85 bg-white/5 backdrop-blur-2 px-3 py-1 rounded-3xl shadow-md
                                border border-white/20 transition-all duration-300
                                hover:text-indigo-200/85 hover:bg-white/5">Mark as Completed</button>
                        </form>
                    </div>
                </li>
            @endif
        @empty
            <li class="text-center">No Task Found</li>
        @endforelse
        @if($tasks->isNotEmpty() && $tasks->where('status', 'pending')->isEmpty())
            <li class="text-center">No Task Found</li>
        @endif
    </ul>
    @if($tasks->where('status','!=', 'pending')->isNotEmpty())
        <h1 class="text-4xl font-bold m-4 text-center">Archived tasks</h1>
        <ul class="space-y-4 px-6 max-w-3xl mx-auto pb-8">
            @foreach($tasks->where('status', '!=', 'pending') as $task)
                <li class="border border-white/20 rounded-3xl backdrop-blur-sm bg-white/10 shadow-lg hover:shadow-xl transition-all duration-300 p-6">
                    <strong class="text-xl font-bold">{{ $task->title }}</strong>

                    <div class="flex flex-wrap gap-x-6 gap-y-1 mt-2 text-sm opacity-75">
                        <span>Due: {{Carbon::parse($task->due_date)->format('M d, Y')}}</span>
                        <span>Priority: {{ ucfirst($task->priority) }}</span>
                        <span>Status: {{ $task->status }}</span>
                    </div>

                    <div class="flex flex-wrap gap-2 mt-4 items-center">
                        <a href="{{route('tasks.show',$task->id)}}" class="text-lg text-cyan-50/85 bg-white/5 backdrop-blur-2 px-3 py-1 rounded-3xl shadow-md
                            border border-white/20 transition-all duration-300
                            hover:text-indigo-200/85 hover:bg-white/5">View more</a>
                        <form action="{{ route('tasks.destroy',$task->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?')" class="contents">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-lg text-cyan-50/85 bg-white/5 backdrop-blur-2 px-3 py-1 rounded-3xl shadow-md
                                border border-white/20 transition-all duration-300
                                hover:text-indigo-200/85 hover:bg-white/5">Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
