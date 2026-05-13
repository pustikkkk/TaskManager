<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    private function makeTask(User $user, array $attrs = []): Task
    {
        return Task::create(array_merge([
            'user_id'     => $user->id,
            'title'       => 'Test Task',
            'description' => null,
            'due_date'    => now()->addDays(3)->toDateString(),
            'priority'    => 'medium',
            'status'      => 'pending',
        ], $attrs));
    }

    public function test_authenticated_user_can_view_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/dashboard')->assertStatus(200);
    }

    public function test_authenticated_user_can_create_a_task(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/tasks', [
            'title'    => 'My Task',
            'priority' => 'high',
            'due_date' => now()->addDays(5)->toDateString(),
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('tasks', ['title' => 'My Task', 'user_id' => $user->id]);
    }

    public function test_authenticated_user_can_view_own_task(): void
    {
        $user = User::factory()->create();
        $task = $this->makeTask($user);

        $this->actingAs($user)->get("/tasks/{$task->id}")->assertStatus(200);
    }

    public function test_user_cannot_view_another_users_task(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $task  = $this->makeTask($owner);

        $this->actingAs($other)->get("/tasks/{$task->id}")->assertStatus(403);
    }

    public function test_authenticated_user_can_update_own_task(): void
    {
        $user = User::factory()->create();
        $task = $this->makeTask($user);

        $response = $this->actingAs($user)->put("/tasks/{$task->id}", [
            'title'    => 'Updated Title',
            'priority' => 'low',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Updated Title']);
    }

    public function test_user_cannot_update_another_users_task(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $task  = $this->makeTask($owner);

        $this->actingAs($other)->put("/tasks/{$task->id}", [
            'title'    => 'Hacked',
            'priority' => 'low',
        ])->assertStatus(403);
    }

    public function test_authenticated_user_can_delete_own_task(): void
    {
        $user = User::factory()->create();
        $task = $this->makeTask($user);

        $this->actingAs($user)->delete("/tasks/{$task->id}")->assertRedirect(route('dashboard'));
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_user_cannot_delete_another_users_task(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $task  = $this->makeTask($owner);

        $this->actingAs($other)->delete("/tasks/{$task->id}")->assertStatus(403);
        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }

    public function test_complete_action_sets_status_to_completed(): void
    {
        $user = User::factory()->create();
        $task = $this->makeTask($user);

        $this->actingAs($user)->patch("/tasks/{$task->id}/complete");

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status' => 'completed']);
    }

    public function test_user_cannot_complete_another_users_task(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $task  = $this->makeTask($owner);

        $this->actingAs($other)->patch("/tasks/{$task->id}/complete")->assertStatus(403);
    }

    // --- Dashboard access ---

    public function test_guest_is_redirected_from_dashboard_to_login(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_unverified_user_is_redirected_to_email_verification(): void
    {
        $user = User::factory()->unverified()->create();

        $this->actingAs($user)->get('/dashboard')->assertRedirect('/verify-email');
    }

    // --- View rendering ---

    public function test_create_form_renders_for_authenticated_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/tasks/create')->assertStatus(200);
    }

    public function test_owner_can_view_edit_form(): void
    {
        $user = User::factory()->create();
        $task = $this->makeTask($user);

        $this->actingAs($user)->get("/tasks/{$task->id}/edit")->assertStatus(200);
    }

    public function test_other_user_cannot_view_edit_form(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $task  = $this->makeTask($owner);

        $this->actingAs($other)->get("/tasks/{$task->id}/edit")->assertStatus(403);
    }

    // --- Store validation ---

    public function test_store_fails_without_title(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/tasks', [
            'priority' => 'medium',
        ])->assertSessionHasErrors(['title']);
    }

    public function test_store_fails_without_priority(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/tasks', [
            'title' => 'Some Task',
        ])->assertSessionHasErrors(['priority']);
    }

    public function test_store_fails_with_invalid_priority_value(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/tasks', [
            'title'    => 'Some Task',
            'priority' => 'urgent',
        ])->assertSessionHasErrors(['priority']);
    }

    public function test_store_fails_with_past_due_date(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/tasks', [
            'title'    => 'Some Task',
            'priority' => 'medium',
            'due_date' => now()->subDay()->toDateString(),
        ])->assertSessionHasErrors(['due_date']);
    }

    // --- Update validation ---

    public function test_update_fails_without_title(): void
    {
        $user = User::factory()->create();
        $task = $this->makeTask($user);

        $this->actingAs($user)->put("/tasks/{$task->id}", [
            'priority' => 'low',
        ])->assertSessionHasErrors(['title']);
    }
}
