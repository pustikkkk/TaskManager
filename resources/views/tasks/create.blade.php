@extends('layouts.app')
@section('title', 'Create a task')
@section('content')
    <form action='{{route('tasks.store')}}' method='POST'>
        <div>

        </div>
    </form>
@endsection
