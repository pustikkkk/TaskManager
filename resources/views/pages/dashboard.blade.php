@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <h1 class="text-4xl font-bold m-4 text-center">Task Dashboard</h1>
    <ul>
        @forelse($tasks as $task)
            <li>{{ $task->title }}</li>
        @empty
            <li class="text-center">No Task Found</li>
        @endforelse
    </ul>
@endsection
