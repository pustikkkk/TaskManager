@php use Carbon\Carbon; @endphp
@extends('layouts.app')
@section('title', 'Show task')
@section('content')
    <div>
        <h1>{{$task->title}}</h1>
        <p><strong>Status:</strong> {{$task->status}}</p>
        <p><strong>Priority:</strong> {{$task->priority}}</p>

        <p id="description">Description:{{$task->description}}</p>
        <p>Due: {{Carbon::parse($task->due_date)->format('M d, Y')}}</p>
    </div>
@endsection
