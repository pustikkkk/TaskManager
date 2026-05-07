@extends('layouts.app')
@section('title', 'Create a task')
@section('content')
    <form action='{{route('tasks.update',$task->id)}}' method='POST'>
        @csrf
        @method('PATCH')
        <div>
            <div>
                <label for="title">Title</label>
                <input id="title" name="title" type="text" placeholder="Enter a title" value="{{ old('title', $task->title) }}">
                @error('title')
                <p class="text-red-500">Invalid title</p>
                @enderror
            </div>
            <div>
                <label for="description">Description</label>
                <textarea id="description" name="description" type="text" placeholder="Description...">{{ old('description', $task->description) }}</textarea>
                @error('description')
                <p class="text-red-500">Invalid description</p>
                @enderror
            </div>
            <div>
                <label for="due_date">Due date</label>
                <input id="due_date" name="due_date" type="date" value="{{old('due_date', $task->due_date)}}">
                @error('due_date')
                <p class="text-red-500">Invalid date</p>
                @enderror
            </div>
            <div>
                <label for="priority">Priority</label>
                <select name="priority" id="priority">
                    <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{old('priority', $task->priority == 'medium' ? 'selected' : '')}}>Medium</option>
                    <option value="high" {{old('priority', $task->priority == 'high' ? 'selected' : '')}}>High</option>
                </select>
            </div>
            @if($task->status == 'pending')
                <div>
                    <label>
                        Mark as completed
                        <input type="checkbox" name="status" value="completed">
                    </label>
                </div>
            @endif
            <button type="submit">Save</button>
        </div>
    </form>
@endsection
