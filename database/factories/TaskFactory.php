<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'     => User::factory(),
            'title'       => fake()->unique()->sentence(3),
            'description' => null,
            'due_date'    => now()->addDays(3)->toDateString(),
            'priority'    => 'medium',
            'status'      => 'pending',
        ];
    }

    public function pending(): static
    {
        return $this->state(['status' => 'pending']);
    }

    public function completed(): static
    {
        return $this->state(['status' => 'completed']);
    }

    public function expired(): static
    {
        return $this->state(['status' => 'expired']);
    }

    public function highPriority(): static
    {
        return $this->state(['priority' => 'high']);
    }
}
