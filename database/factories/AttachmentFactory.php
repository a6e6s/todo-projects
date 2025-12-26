<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Attachment;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Attachment>
 */
class AttachmentFactory extends Factory
{
    protected $model = Attachment::class;

    public function definition(): array
    {
        $extensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'png', 'jpg', 'jpeg', 'gif', 'zip'];
        $extension = fake()->randomElement($extensions);

        return [
            'attachable_id' => Task::factory(),
            'attachable_type' => Task::class,
            'file_path' => 'attachments/' . fake()->uuid() . '.' . $extension,
            'file_name' => fake()->word() . '.' . $extension,
            'file_size' => fake()->numberBetween(1024, 10485760), // 1KB to 10MB
        ];
    }

    public function forTask(Task $task = null): static
    {
        return $this->state(fn (array $attributes) => [
            'attachable_id' => $task?->id ?? Task::factory(),
            'attachable_type' => Task::class,
        ]);
    }

    public function forProject(Project $project = null): static
    {
        return $this->state(fn (array $attributes) => [
            'attachable_id' => $project?->id ?? Project::factory(),
            'attachable_type' => Project::class,
        ]);
    }

    public function image(): static
    {
        $extension = fake()->randomElement(['png', 'jpg', 'jpeg', 'gif', 'webp']);

        return $this->state(fn (array $attributes) => [
            'file_path' => 'attachments/' . fake()->uuid() . '.' . $extension,
            'file_name' => fake()->word() . '.' . $extension,
        ]);
    }
}
