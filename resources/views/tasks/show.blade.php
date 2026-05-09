@php use Carbon\Carbon; @endphp
@extends('layouts.app')
@section('title', 'Show task')
@section('content')
    <div class="flex items-center justify-center py-10">
        <div class="w-11/12 sm:w-3/5 border-2 rounded-3xl backdrop-blur-sm bg-white/10 border-white/10 shadow-lg hover:shadow-xl transition-all duration-300 p-10">
            <h1 class="text-3xl font-bold mb-6">{{$task->title}}</h1>
            <div class="border-t border-white/20 pt-5 space-y-3">
                <p><span class="text-sm font-medium opacity-75">Status</span><br>{{ $task->status }}</p>
                <p><span class="text-sm font-medium opacity-75">Priority</span><br>{{ $task->priority }}</p>
                <p><span class="text-sm font-medium opacity-75">Due date</span><br>{{Carbon::parse($task->due_date)->format('M d, Y')}}</p>
                <p id="description"><span class="text-sm font-medium opacity-75">Description</span><br>{{$task->description}}</p>
            </div>
        </div>
    </div>
@endsection
