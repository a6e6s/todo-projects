<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Enums\Priority;
use App\Enums\TaskStatus;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateTaskModal extends Component
{
    public bool $open = false;
    public ?int $projectId = null;

    #[Validate('required|string|min:2|max:255')]
    public string $title = '';

    public string $description = '';
    public string $priority = 'medium';
    public string $status = 'todo';
    public ?string $dueDate = null;
    public ?int $effortScore = null;

    // ─────────────────────────────────────────────────────────────
    // Actions
    // ─────────────────────────────────────────────────────────────

    #[On('open-create-task-modal')]
    public function openModal(?int $projectId = null): void
    {
        $this->reset(['title', 'description', 'priority', 'status', 'dueDate', 'effortScore']);
        $this->projectId = $projectId;
        $this->open = true;
    }

    public function create(): void
    {
        $this->validate();

        if (!$this->projectId) {
            return;
        }

        // Verify project ownership
        $project = Project::where('id', $this->projectId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$project) {
            return;
        }

        $maxOrder = Task::where('project_id', $this->projectId)
            ->where('status', $this->status)
            ->max('sort_order') ?? 0;

        Task::create([
            'project_id' => $this->projectId,
            'title' => $this->title,
            'description' => $this->description ?: null,
            'priority' => $this->priority,
            'status' => $this->status,
            'due_date' => $this->dueDate ?: null,
            'effort_score' => $this->effortScore,
            'sort_order' => $maxOrder + 1,
        ]);

        $this->close();

        // Refresh kanban board
        $this->dispatch('task-created');
    }

    public function close(): void
    {
        $this->open = false;
    }

    // ─────────────────────────────────────────────────────────────
    // Render
    // ─────────────────────────────────────────────────────────────

    public function render(): View
    {
        return view('livewire.create-task-modal');
    }
}
