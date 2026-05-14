@php use Carbon\Carbon; @endphp
{{--
  Dashboard: two sections — pending tasks (always shown) and archived tasks (completed/expired, shown only when they exist).
  Each section has its own filter form; hidden inputs carry the other section's filter state so both survive on every submission.
--}}
@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

    {{-- Pending heading + filters --}}
    <h1 class="text-4xl font-bold m-4 text-center">Task Dashboard</h1>
    @if($hasPendingTasks)
    <form method="GET" action="{{ route('dashboard') }}"
          class="flex flex-wrap gap-2 px-6 max-w-3xl mx-auto mb-4">
            {{-- Preserve archive params --}}
            <input type="hidden" name="archive_sort"     value="{{ request('archive_sort', 'date_desc') }}">
            <input type="hidden" name="archive_priority" value="{{ request('archive_priority') }}">
            <input type="hidden" name="archive_due_date" value="{{ request('archive_due_date') }}">
            <input type="hidden" name="archive_status"   value="{{ request('archive_status') }}">

            <select name="sort" onchange="this.form.submit()"
                    class="text-sm text-cyan-50/85 bg-white/5 backdrop-blur-sm px-3 py-1.5 rounded-3xl shadow-md
                           border border-white/20 transition-all duration-300 cursor-pointer
                           hover:bg-white/10 focus:outline-none focus:border-white/45
                           [&>option]:bg-blue-700 [&>option]:text-white">
                <option value="date_asc"      {{ request('sort', 'date_asc') == 'date_asc'      ? 'selected' : '' }}>Date (earliest first)</option>
                <option value="date_desc"     {{ request('sort', 'date_asc') == 'date_desc'     ? 'selected' : '' }}>Date (latest first)</option>
                <option value="priority_asc"  {{ request('sort', 'date_asc') == 'priority_asc'  ? 'selected' : '' }}>Priority (low → high)</option>
                <option value="priority_desc" {{ request('sort', 'date_asc') == 'priority_desc' ? 'selected' : '' }}>Priority (high → low)</option>
            </select>
            <select name="priority" onchange="this.form.submit()"
                    class="text-sm text-cyan-50/85 bg-white/5 backdrop-blur-sm px-3 py-1.5 rounded-3xl shadow-md
                           border border-white/20 transition-all duration-300 cursor-pointer
                           hover:bg-white/10 focus:outline-none focus:border-white/45
                           [&>option]:bg-blue-700 [&>option]:text-white">
                <option value=""       {{ request('priority') == ''       ? 'selected' : '' }}>All priorities</option>
                <option value="low"    {{ request('priority') == 'low'    ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high"   {{ request('priority') == 'high'   ? 'selected' : '' }}>High</option>
            </select>
            <select name="due_date" onchange="this.form.submit()"
                    class="text-sm text-cyan-50/85 bg-white/5 backdrop-blur-sm px-3 py-1.5 rounded-3xl shadow-md
                           border border-white/20 transition-all duration-300 cursor-pointer
                           hover:bg-white/10 focus:outline-none focus:border-white/45
                           [&>option]:bg-blue-700 [&>option]:text-white">
                <option value=""      {{ request('due_date') == ''      ? 'selected' : '' }}>All dates</option>
                <option value="today" {{ request('due_date') == 'today' ? 'selected' : '' }}>Today</option>
                <option value="week"  {{ request('due_date') == 'week'  ? 'selected' : '' }}>Next 7 days</option>
                <option value="month" {{ request('due_date') == 'month' ? 'selected' : '' }}>This month</option>
            </select>
    </form>
    @endif

    <ul class="space-y-4 px-6 max-w-3xl mx-auto pb-8">
        @forelse($pendingTasks as $task)
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
        @empty
            <li class="text-center flex flex-col items-center gap-3">
                @if($hasPendingTasks)
                    <span>No tasks match the current filters</span>
                    <a href="{{ route('dashboard') }}" class="text-lg text-cyan-50/85 bg-white/5 backdrop-blur-2 px-4 py-1.5 rounded-3xl shadow-md
                        border border-white/20 transition-all duration-300
                        hover:text-indigo-200/85 hover:bg-white/10">Clear filters</a>
                @else
                    <span>No Task Found</span>
                    <a href="{{ route('tasks.create') }}" class="text-lg text-cyan-50/85 bg-white/5 backdrop-blur-2 px-4 py-1.5 rounded-3xl shadow-md
                        border border-white/20 transition-all duration-300
                        hover:text-indigo-200/85 hover:bg-white/10">Create your first task</a>
                @endif
            </li>
        @endforelse
    </ul>

    @if($hasArchivedTasks)
        {{-- Archived heading + filters --}}
        <h1 class="text-4xl font-bold m-4 text-center">Archived tasks</h1>
        <form method="GET" action="{{ route('dashboard') }}"
              class="flex flex-wrap gap-2 px-6 max-w-3xl mx-auto mb-4">
                {{-- Preserve pending params --}}
                <input type="hidden" name="sort"     value="{{ request('sort', 'date_asc') }}">
                <input type="hidden" name="priority" value="{{ request('priority') }}">
                <input type="hidden" name="due_date" value="{{ request('due_date') }}">

                <select name="archive_sort" onchange="this.form.submit()"
                        class="text-sm text-cyan-50/85 bg-white/5 backdrop-blur-sm px-3 py-1.5 rounded-3xl shadow-md
                               border border-white/20 transition-all duration-300 cursor-pointer
                               hover:bg-white/10 focus:outline-none focus:border-white/45
                               [&>option]:bg-blue-700 [&>option]:text-white">
                    <option value="date_desc"     {{ request('archive_sort', 'date_desc') == 'date_desc'     ? 'selected' : '' }}>Date (latest first)</option>
                    <option value="date_asc"      {{ request('archive_sort', 'date_desc') == 'date_asc'      ? 'selected' : '' }}>Date (earliest first)</option>
                    <option value="priority_asc"  {{ request('archive_sort', 'date_desc') == 'priority_asc'  ? 'selected' : '' }}>Priority (low → high)</option>
                    <option value="priority_desc" {{ request('archive_sort', 'date_desc') == 'priority_desc' ? 'selected' : '' }}>Priority (high → low)</option>
                    <option value="status_asc"    {{ request('archive_sort', 'date_desc') == 'status_asc'    ? 'selected' : '' }}>Status (completed first)</option>
                    <option value="status_desc"   {{ request('archive_sort', 'date_desc') == 'status_desc'   ? 'selected' : '' }}>Status (expired first)</option>
                </select>

                <select name="archive_priority" onchange="this.form.submit()"
                        class="text-sm text-cyan-50/85 bg-white/5 backdrop-blur-sm px-3 py-1.5 rounded-3xl shadow-md
                               border border-white/20 transition-all duration-300 cursor-pointer
                               hover:bg-white/10 focus:outline-none focus:border-white/45
                               [&>option]:bg-blue-700 [&>option]:text-white">
                    <option value=""       {{ request('archive_priority') == ''       ? 'selected' : '' }}>All priorities</option>
                    <option value="low"    {{ request('archive_priority') == 'low'    ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ request('archive_priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high"   {{ request('archive_priority') == 'high'   ? 'selected' : '' }}>High</option>
                </select>
                <select name="archive_due_date" onchange="this.form.submit()"
                        class="text-sm text-cyan-50/85 bg-white/5 backdrop-blur-sm px-3 py-1.5 rounded-3xl shadow-md
                               border border-white/20 transition-all duration-300 cursor-pointer
                               hover:bg-white/10 focus:outline-none focus:border-white/45
                               [&>option]:bg-blue-700 [&>option]:text-white">
                    <option value=""      {{ request('archive_due_date') == ''      ? 'selected' : '' }}>All dates</option>
                    <option value="today" {{ request('archive_due_date') == 'today' ? 'selected' : '' }}>Today</option>
                    <option value="week"  {{ request('archive_due_date') == 'week'  ? 'selected' : '' }}>Next 7 days</option>
                    <option value="month" {{ request('archive_due_date') == 'month' ? 'selected' : '' }}>This month</option>
                </select>
                <select name="archive_status" onchange="this.form.submit()"
                        class="text-sm text-cyan-50/85 bg-white/5 backdrop-blur-sm px-3 py-1.5 rounded-3xl shadow-md
                               border border-white/20 transition-all duration-300 cursor-pointer
                               hover:bg-white/10 focus:outline-none focus:border-white/45
                               [&>option]:bg-blue-700 [&>option]:text-white">
                    <option value=""          {{ request('archive_status') == ''          ? 'selected' : '' }}>All statuses</option>
                    <option value="completed" {{ request('archive_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="expired"   {{ request('archive_status') == 'expired'   ? 'selected' : '' }}>Expired</option>
                </select>
        </form>

        <ul class="space-y-4 px-6 max-w-3xl mx-auto pb-8">
            @forelse($archivedTasks as $task)
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
            @empty
                <li class="text-center flex flex-col items-center gap-3">
                    <span>No tasks match the current filters</span>
                    <a href="{{ route('dashboard', ['sort' => request('sort', 'date_asc'), 'priority' => request('priority'), 'due_date' => request('due_date')]) }}"
                       class="text-lg text-cyan-50/85 bg-white/5 backdrop-blur-2 px-4 py-1.5 rounded-3xl shadow-md
                           border border-white/20 transition-all duration-300
                           hover:text-indigo-200/85 hover:bg-white/10">Clear filters</a>
                </li>
            @endforelse
        </ul>
    @endif
@endsection
