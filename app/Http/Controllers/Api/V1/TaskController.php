<?php
// API task controller — all responses are wrapped in TaskResource; ownership enforced via TaskPolicy

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return TaskResource::collection(
            auth()->user()->tasks()->latest()->paginate(15)
        );
    }

    public function pending(Request $request): AnonymousResourceCollection
    {
        return TaskResource::collection(
            auth()->user()->tasks()
                ->where('status', 'pending')
                ->when($request->boolean('unsynced'), fn ($q) => $q->unsynced())
                ->latest()
                ->paginate(15)
        );
    }

    public function archived(): AnonymousResourceCollection
    {
        return TaskResource::collection(
            auth()->user()->tasks()
                ->whereIn('status', ['completed', 'expired'])
                ->latest()
                ->paginate(15)
        );
    }

    public function show(Task $task): TaskResource
    {
        $this->authorize('view', $task);
        return new TaskResource($task);
    }

    public function store(StoreTaskRequest $request): TaskResource
    {
        $task = Task::create(array_merge(
            $request->validated(),
            ['user_id' => auth()->id()]
        ));
        return new TaskResource($task);
    }

    public function update(UpdateTaskRequest $request, Task $task): TaskResource
    {
        $this->authorize('update', $task);
        $task->update($request->validated());
        return new TaskResource($task);
    }

    public function complete(Task $task): TaskResource
    {
        $this->authorize('update', $task);
        $task->update(['status' => 'completed']);
        return new TaskResource($task);
    }

    public function destroy(Task $task): JsonResponse
    {
        $this->authorize('delete', $task);
        $task->delete();
        return response()->json(null, 204);
    }
    public function markSynced(Task $task, Request $request) {
        abort_unless($task->user_id === $request->user()->id, 403);
        $task->update(['synced_at' => now()]);
        $task->save();
        return response()->json(['id' => $task->id, 'synced_at' => $task->synced_at]);

    }
}
