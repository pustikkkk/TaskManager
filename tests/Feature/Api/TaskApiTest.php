<?php
// Added: new file — full API task CRUD coverage using Sanctum::actingAs(); tests all 8 endpoints
// including ownership enforcement (403), pagination shape, and TaskResource field structure

namespace Tests\Feature\Api;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    private function makeTask(User $user, array $attrs = []): Task
    {
        return Task::factory()->for($user)->create($attrs);
    }

    // --- Unauthenticated access ---

    public function test_unauthenticated_request_to_tasks_returns_401(): void
    {
        $this->getJson('/api/v1/tasks')->assertStatus(401);
    }

    // --- GET /api/v1/tasks ---

    public function test_index_returns_only_authenticated_users_tasks(): void
    {
        $user  = User::factory()->create();
        $other = User::factory()->create();

        $this->makeTask($user, ['title' => 'Mine']);
        $this->makeTask($other, ['title' => 'Not Mine']);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/v1/tasks')->assertStatus(200);

        $titles = collect($response->json('data'))->pluck('title');
        $this->assertTrue($titles->contains('Mine'));
        $this->assertFalse($titles->contains('Not Mine'));
    }

    public function test_index_response_is_paginated(): void
    {
        $user = User::factory()->create();
        $this->makeTask($user);

        Sanctum::actingAs($user);

        $this->getJson('/api/v1/tasks')
            ->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta']);
    }

    // --- GET /api/v1/tasks/pending ---

    public function test_pending_returns_only_pending_tasks(): void
    {
        $user = User::factory()->create();
        $this->makeTask($user, ['title' => 'Pending Task', 'status' => 'pending']);
        $this->makeTask($user, ['title' => 'Done Task',    'status' => 'completed']);
        $this->makeTask($user, ['title' => 'Old Task',     'status' => 'expired']);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/v1/tasks/pending')->assertStatus(200);

        $titles = collect($response->json('data'))->pluck('title');
        $this->assertTrue($titles->contains('Pending Task'));
        $this->assertFalse($titles->contains('Done Task'));
        $this->assertFalse($titles->contains('Old Task'));
    }

    // --- GET /api/v1/tasks/archived ---

    public function test_archived_returns_completed_and_expired_tasks(): void
    {
        $user = User::factory()->create();
        $this->makeTask($user, ['title' => 'Pending Task', 'status' => 'pending']);
        $this->makeTask($user, ['title' => 'Done Task',    'status' => 'completed']);
        $this->makeTask($user, ['title' => 'Old Task',     'status' => 'expired']);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/v1/tasks/archived')->assertStatus(200);

        $titles = collect($response->json('data'))->pluck('title');
        $this->assertTrue($titles->contains('Done Task'));
        $this->assertTrue($titles->contains('Old Task'));
        $this->assertFalse($titles->contains('Pending Task'));
    }

    // --- POST /api/v1/tasks ---

    public function test_store_creates_task_and_returns_resource(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/v1/tasks', [
            'title'    => 'New API Task',
            'priority' => 'high',
            'due_date' => now()->addDays(5)->toDateString(),
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['data' => ['id', 'title', 'description', 'due_date', 'priority', 'status', 'created_at', 'updated_at']]);

        $this->assertDatabaseHas('tasks', ['title' => 'New API Task', 'user_id' => $user->id]);
    }

    public function test_store_fails_without_title(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $this->postJson('/api/v1/tasks', ['priority' => 'medium'])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    }

    public function test_store_fails_without_priority(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $this->postJson('/api/v1/tasks', ['title' => 'Some Task'])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['priority']);
    }

    public function test_store_fails_with_past_due_date(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $this->postJson('/api/v1/tasks', [
            'title'    => 'Some Task',
            'priority' => 'medium',
            'due_date' => now()->subDay()->toDateString(),
        ])->assertStatus(422)->assertJsonValidationErrors(['due_date']);
    }

    // --- GET /api/v1/tasks/{task} ---

    public function test_show_returns_own_task(): void
    {
        $user = User::factory()->create();
        $task = $this->makeTask($user, ['title' => 'My Task']);
        Sanctum::actingAs($user);

        $this->getJson("/api/v1/tasks/{$task->id}")
            ->assertStatus(200)
            ->assertJsonPath('data.title', 'My Task');
    }

    public function test_show_returns_403_for_other_users_task(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $task  = $this->makeTask($owner);

        Sanctum::actingAs($other);

        $this->getJson("/api/v1/tasks/{$task->id}")->assertStatus(403);
    }

    // --- PUT /api/v1/tasks/{task} ---

    public function test_update_modifies_own_task(): void
    {
        $user = User::factory()->create();
        $task = $this->makeTask($user);
        Sanctum::actingAs($user);

        $this->putJson("/api/v1/tasks/{$task->id}", [
            'title'    => 'Updated Title',
            'priority' => 'low',
        ])->assertStatus(200);

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Updated Title']);
    }

    public function test_update_returns_403_for_other_users_task(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $task  = $this->makeTask($owner);

        Sanctum::actingAs($other);

        $this->putJson("/api/v1/tasks/{$task->id}", [
            'title'    => 'Hacked',
            'priority' => 'low',
        ])->assertStatus(403);
    }

    // --- PATCH /api/v1/tasks/{task}/complete ---

    public function test_complete_sets_status_to_completed(): void
    {
        $user = User::factory()->create();
        $task = $this->makeTask($user, ['status' => 'pending']);
        Sanctum::actingAs($user);

        $this->patchJson("/api/v1/tasks/{$task->id}/complete")->assertStatus(200);

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status' => 'completed']);
    }

    public function test_complete_returns_403_for_other_users_task(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $task  = $this->makeTask($owner);

        Sanctum::actingAs($other);

        $this->patchJson("/api/v1/tasks/{$task->id}/complete")->assertStatus(403);
    }

    // --- DELETE /api/v1/tasks/{task} ---

    public function test_destroy_deletes_own_task_and_returns_204(): void
    {
        $user = User::factory()->create();
        $task = $this->makeTask($user);
        Sanctum::actingAs($user);

        $this->deleteJson("/api/v1/tasks/{$task->id}")->assertStatus(204);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_destroy_returns_403_for_other_users_task(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $task  = $this->makeTask($owner);

        Sanctum::actingAs($other);

        $this->deleteJson("/api/v1/tasks/{$task->id}")->assertStatus(403);
        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }
}
