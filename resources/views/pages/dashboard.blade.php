@php use Carbon\Carbon; @endphp
@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <h1 class="text-4xl font-bold m-4 text-center">Task Dashboard</h1>
    <ul>
        @forelse($tasks as $task)
            @if($task->status == 'pending')
                <li>
                    <strong>{{ $task->title }}</strong>

                    <div>
                        Due: {{Carbon::parse($task->due_date)->format('M d, Y')}}
                    </div>

                    <div>
                        Priority: {{ ucfirst($task->priority) }}
                    </div>

                    <div>
                        Status: {{ $task->status }}
                    </div>

                    <div>
                        <div>
                            <a href="{{ route('tasks.edit',$task->id) }}">Edit</a>
                        </div>
                        <div>
                            <a href="{{route('tasks.show',$task->id)}}">View more</a>
                        </div>
                        <div>
                            <form action="{{ route('tasks.destroy',$task->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        </div>
                            <div>
                                <form action="{{route('tasks.complete',$task->id)}}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit">Mark as Completed</button>
                                </form>
                            </div>
                    </div>

                </li>
            @else
                <li class="text-center">No Task Found</li>
            @endif
        @empty
            <li class="text-center">No Task Found</li>
        @endforelse
    </ul>
    @if($tasks->where('status','!=', 'pending')->isNotEmpty())
        <h1 class="text-4xl font-bold m-4 text-center">Archived tasks</h1>
        <ul>
            @foreach($tasks->where('status', '!=', 'pending') as $task)
                    <li>
                        <strong>{{ $task->title }}</strong>

                        <div>
                            Due: {{Carbon::parse($task->due_date)->format('M d, Y')}}
                        </div>

                        <div>
                            Priority: {{ ucfirst($task->priority) }}
                        </div>

                        <div>
                            Status: {{ $task->status }}
                        </div>

                        <div>
                            <div>
                                <a href="{{route('tasks.show',$task->id)}}">View more</a>
                            </div>
                            <div>
                                <form action="{{ route('tasks.destroy',$task->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Delete</button>
                                </form>
                            </div>
                        </div>
                    </li>
            @endforeach
        </ul>
    @endif
@endsection
