@extends('layouts.app')
@section('title', 'Create a task')
@section('content')
    <form action='{{route('tasks.store')}}' method='POST'>
        @csrf
        <div>
            <div>
                <label for="title">Title</label>
                <input id="title" name="title" type="text" placeholder="Enter a title">
            </div>
            <div>
                <label for="description">Description</label>
                <textarea id="description" name="description" type="text" placeholder="Description..."></textarea>
            </div>
            <div>
                <label for="due_date">Due date</label>
                <input id="due_date" name="due_date" type="date">
            </div>
            <div>
                <label for="priority">Priority</label>
                <select name="priority" id="priority">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
            </div>
            <button type="submit">Create</button>
        </div>
    </form>
@endsection
