@extends('layouts.app')
@section('title', 'Edit task')
@section('content')
    <div class="flex items-center justify-center py-10">
        <form action='{{route('tasks.update',$task->id)}}' method='POST' class="w-11/12 sm:w-3/5 border-2 rounded-3xl backdrop-blur-sm bg-white/2 border-white/10 shadow-lg hover:shadow-xl transition-all duration-300">
            @csrf
            @method('PATCH')
            <div class="m-8">
                <h2 class="text-2xl font-bold text-center mb-8">Edit Task</h2>
                <div class="mb-5 flex flex-col gap-1">
                    <label for="title" class="font-medium text-sm">Title</label>
                    <input id="title" name="title" type="text" placeholder="Enter a title" value="{{ old('title', $task->title) }}" class="appearance-none outline-none ring-0 focus:ring-0 w-full
                    text-lg text-cyan-50/85 bg-white/5 backdrop-blur-3xl px-3 py-2 rounded-3xl shadow-md
                    border border-white/20 transition-all duration-300
                    hover:text-indigo-200/85 focus:bg-white/10 focus:outline-none focus:border-white/45">
                    @error('title')
                    <p class="text-red-500 text-sm">Invalid title</p>
                    @enderror
                </div>
                <div class="mb-5 flex flex-col gap-1">
                    <label for="description" class="font-medium text-sm">Description</label>
                    <textarea id="description" name="description" placeholder="Description..." rows="4" class="appearance-none outline-none ring-0 focus:ring-0 w-full
                    text-lg text-cyan-50/85 bg-white/5 backdrop-blur-3xl px-3 py-2 rounded-3xl shadow-md
                    border border-white/20 transition-all duration-300
                    hover:text-indigo-200/85 focus:bg-white/10 focus:outline-none focus:border-white/45">{{ old('description', $task->description) }}</textarea>
                    @error('description')
                    <p class="text-red-500 text-sm">Invalid description</p>
                    @enderror
                </div>
                <div class="mb-5 flex flex-col gap-1">
                    <label for="due_date" class="font-medium text-sm">Due date</label>
                    <input id="due_date" name="due_date" type="date" value="{{old('due_date', $task->due_date)}}" class="appearance-none outline-none ring-0 focus:ring-0 w-full
                    text-lg text-cyan-50/85 bg-white/5 backdrop-blur-3xl px-3 py-2 rounded-3xl shadow-md
                    border border-white/20 transition-all duration-300
                    hover:text-indigo-200/85 focus:bg-white/10 focus:outline-none focus:border-white/45">
                    @error('due_date')
                    <p class="text-red-500 text-sm">Invalid date</p>
                    @enderror
                </div>
                <div class="mb-5 flex flex-col gap-1">
                    <label for="priority" class="font-medium text-sm">Priority</label>
                    <select name="priority" id="priority" class="appearance-none outline-none ring-0 focus:ring-0 w-full
                    text-lg text-cyan-50/85 bg-white/5 backdrop-blur-3xl px-3 py-2 rounded-3xl shadow-md
                    border border-white/20 transition-all duration-300
                    hover:text-indigo-200/85 focus:bg-white/10 focus:outline-none focus:border-white/45">
                        <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{old('priority', $task->priority == 'medium' ? 'selected' : '')}}>Medium</option>
                        <option value="high" {{old('priority', $task->priority == 'high' ? 'selected' : '')}}>High</option>
                    </select>
                </div>
                @if($task->status == 'pending')
                    <div class="mb-5 flex items-center gap-2">
                        <input type="checkbox" name="status" value="completed" id="completed">
                        <label for="completed" class="font-medium text-sm">Mark as completed</label>
                    </div>
                @endif
                <div class="flex justify-center mt-6">
                    <button type="submit" class="text-lg text-cyan-50/85 bg-white/5 px-8 py-2 rounded-3xl shadow-md
                        border border-white/20 transition-all duration-300 hover:text-indigo-200/85
                        hover:bg-white/5">Save</button>
                </div>
            </div>
        </form>
    </div>
@endsection
