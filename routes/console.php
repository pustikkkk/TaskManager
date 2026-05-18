<?php


// The new way to handle scheduled tasks in laravel
use App\Models\Task;
use Carbon\Carbon;

Schedule::call(function () {
    Task::where('status', '=', 'pending')->whereDate('due_date', '<', Carbon::today())->update(['status' => 'expired']);
})->hourly();


