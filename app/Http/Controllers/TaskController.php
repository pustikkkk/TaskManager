<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
    public function store(StoreTaskRequest $request) {
        Task::create(
            array_merge(
                $request->validated(),
                ['user_id' => auth()->id()]
            )
        );
        return redirect()->route('dashboard')->with('success', 'Task created successfully');
    }

    public function create() {
        return view('tasks.create');
    }

    public function show(Task $task) {
        $this->authorize('view', $task); // Added: enforce TaskPolicy — only owner may view
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task) {
        $this->authorize('update', $task); // Added: enforce TaskPolicy — only owner may open edit form
        return view('tasks.edit', compact('task'));
    }

    public function update(StoreTaskRequest $request, Task $task) {
        $this->authorize('update', $task); // Added: enforce TaskPolicy — only owner may update
        $task->update(
            $request->validated()
        );
        return redirect()->route('dashboard')->with('success', 'Task updated successfully');
    }

    public function complete(Task $task)
    {
        $this->authorize('update', $task); // Added: enforce TaskPolicy — only owner may complete
        $task->update([
            'status' => 'completed'
        ]);
        return redirect()->route('dashboard')->with('success', 'Task completed successfully');
    }

    public function destroy(Task $task) {
        $this->authorize('delete', $task); // Added: enforce TaskPolicy — only owner may delete
        $task->delete();
        return redirect()->route('dashboard')->with('success', 'Task deleted successfully');
    }

    public function index(Request $request) {
        // Pending filters
        $sortBy         = in_array($request->sort, ['date_asc', 'date_desc', 'priority_asc', 'priority_desc'])
                            ? $request->sort : 'date_asc';
        $filterPriority = $request->input('priority', '');
        $filterDue      = $request->input('due_date', '');

        // Archived filters
        $archiveSort     = in_array($request->archive_sort, ['date_asc', 'date_desc', 'priority_asc', 'priority_desc', 'status_asc', 'status_desc']) ? $request->archive_sort : 'date_desc';
        $archivePriority = $request->input('archive_priority', '');
        $archiveDue      = $request->input('archive_due_date', '');
        $archiveStatus   = $request->input('archive_status', '');

        // Pending query
        $query = auth()->user()->tasks()->where('status', 'pending');
        if ($filterPriority) $query->where('priority', $filterPriority);
        if ($filterDue) {
            $today = now()->startOfDay();
            match ($filterDue) {
                'today' => $query->whereDate('due_date', today()),
                'week'  => $query->whereBetween('due_date', [$today, $today->copy()->addDays(6)->endOfDay()]),
                'month' => $query->whereMonth('due_date', now()->month)->whereYear('due_date', now()->year),
                default => null,
            };
        }
        match ($sortBy) {
            'date_asc'      => $query->orderBy('due_date', 'asc'),
            'date_desc'     => $query->orderBy('due_date', 'desc'),
            'priority_asc'  => $query->orderByRaw("CASE priority WHEN 'low' THEN 1 WHEN 'medium' THEN 2 WHEN 'high' THEN 3 END"),
            'priority_desc' => $query->orderByRaw("CASE priority WHEN 'high' THEN 1 WHEN 'medium' THEN 2 WHEN 'low' THEN 3 END"),
            default         => null,
        };
        $pendingTasks    = $query->get();
        $hasPendingTasks = auth()->user()->tasks()->where('status', 'pending')->exists();

        // Archived query
        $archiveQuery = auth()->user()->tasks()->where('status', '!=', 'pending');
        if ($archivePriority) $archiveQuery->where('priority', $archivePriority);
        if ($archiveStatus)   $archiveQuery->where('status', $archiveStatus);
        if ($archiveDue) {
            $today = now()->startOfDay();
            match ($archiveDue) {
                'today' => $archiveQuery->whereDate('due_date', today()),
                'week'  => $archiveQuery->whereBetween('due_date', [$today, $today->copy()->addDays(6)->endOfDay()]),
                'month' => $archiveQuery->whereMonth('due_date', now()->month)->whereYear('due_date', now()->year),
                default => null,
            };
        }
        match ($archiveSort) {
            'date_asc'      => $archiveQuery->orderBy('due_date', 'asc'),
            'date_desc'     => $archiveQuery->orderBy('due_date', 'desc'),
            'priority_asc'  => $archiveQuery->orderByRaw("CASE priority WHEN 'low' THEN 1 WHEN 'medium' THEN 2 WHEN 'high' THEN 3 END"),
            'priority_desc' => $archiveQuery->orderByRaw("CASE priority WHEN 'high' THEN 1 WHEN 'medium' THEN 2 WHEN 'low' THEN 3 END"),
            'status_asc'    => $archiveQuery->orderBy('status', 'asc'),
            'status_desc'   => $archiveQuery->orderBy('status', 'desc'),
            default         => $archiveQuery->orderBy('due_date', 'desc'),
        };
        $archivedTasks    = $archiveQuery->get();
        $hasArchivedTasks = auth()->user()->tasks()->where('status', '!=', 'pending')->exists();

        return view('pages.dashboard', compact('pendingTasks', 'archivedTasks', 'hasPendingTasks', 'hasArchivedTasks'));
    }
}
