<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Priority;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $icons = ['folder', 'briefcase', 'rocket', 'star', 'zap', 'target', 'flag', 'bookmark'];
        $colors = ['#ef4444', '#f97316', '#eab308', '#22c55e', '#06b6d4', '#3b82f6', '#8b5cf6', '#ec4899'];

        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(3),
            'icon' => fake()->randomElement($icons),
            'color' => fake()->randomElement($colors),
            'sort_order' => fake()->numberBetween(0, 100),
            'priority' => fake()->randomElement(Priority::cases()),
            'archived_at' => null,
        ];
    }

    public function archived(): static
    {
        return $this->state(fn (array $attributes) => [
            'archived_at' => now(),
        ]);
    }

    public function highPriority(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => Priority::High,
        ]);
    }
}
