<?php

use App\Http\Controllers\Api\V1\TaskController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

Route::post('v1/tokens', function (Request $request) {
    $request->validate([
        'username' => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    $user = User::where('username', $request->username)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'username' => ['The provided credentials are incorrect.'],
        ]);
    }

    return response()->json([
        'token' => $user->createToken('api-token')->plainTextToken,
    ]);
})->middleware('throttle:login');

Route::prefix('v1')->middleware(['auth:sanctum', 'throttle:api-requests'])->group(function () {
    Route::get('tasks/pending',   [TaskController::class, 'pending']);
    Route::get('tasks/archived',  [TaskController::class, 'archived']);
    Route::get('tasks',           [TaskController::class, 'index']);
    Route::get('tasks/{task}',    [TaskController::class, 'show']);
    Route::post('tasks',          [TaskController::class, 'store']);
    Route::put('tasks/{task}',              [TaskController::class, 'update']);
    Route::patch('tasks/{task}/complete',   [TaskController::class, 'complete']);
    Route::delete('tasks/{task}',           [TaskController::class, 'destroy']);
});
