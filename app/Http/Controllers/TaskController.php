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
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task) {
        return view('tasks.edit', compact('task'));
    }

    public function update(StoreTaskRequest $request, Task $task) {
        $task->update(
            $request->validated()
        );
        return redirect()->route('dashboard')->with('success', 'Task updated successfully');
    }

    public function complete(Task $task)
    {
        $task->update([
            'status' => 'completed'
        ]);
        return redirect()->route('dashboard')->with('success', 'Task completed successfully');
    }

    public function destroy(Task $task) {
        $task->delete();
        return redirect()->route('dashboard')->with('success', 'Task deleted successfully');
    }

    public function index() {
        $tasks = auth()->user()->tasks;
        return view('pages.dashboard', compact('tasks'));
    }
}
