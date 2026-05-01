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
}
