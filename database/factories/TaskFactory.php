<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Priority;
use App\Enums\TaskStatus;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'assigned_to' => fake()->boolean(70) ? User::factory() : null,
            'title' => fake()->sentence(4),
            'description' => fake()->optional()->paragraph(),
            'priority' => fake()->randomElement(Priority::cases()),
            'status' => fake()->randomElement(TaskStatus::cases()),
            'sort_order' => fake()->numberBetween(0, 100),
            'due_date' => fake()->optional()->dateTimeBetween('now', '+30 days'),
            'effort_score' => fake()->optional()->numberBetween(1, 10),
        ];
    }

    public function todo(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => TaskStatus::Todo,
        ]);
    }

    public function doing(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => TaskStatus::Doing,
        ]);
    }

    public function done(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => TaskStatus::Done,
        ]);
    }

    public function highPriority(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => Priority::High,
        ]);
    }

    public function overdue(): static
    {
        return $this->state(fn (array $attributes) => [
            'due_date' => fake()->dateTimeBetween('-7 days', '-1 day'),
            'status' => TaskStatus::Todo,
        ]);
    }

    public function dueToday(): static
    {
        return $this->state(fn (array $attributes) => [
            'due_date' => today(),
        ]);
    }

    public function unassigned(): static
    {
        return $this->state(fn (array $attributes) => [
            'assigned_to' => null,
        ]);
    }
}
