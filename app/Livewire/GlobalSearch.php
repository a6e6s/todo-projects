<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class GlobalSearch extends Component
{
    public bool $open = false;
    public string $query = '';

    // ─────────────────────────────────────────────────────────────
    // Computed Properties
    // ─────────────────────────────────────────────────────────────

    #[Computed]
    public function results(): array
    {
        if (strlen($this->query) < 2) {
            return ['projects' => collect(), 'tasks' => collect()];
        }

        $projects = Project::query()
            ->select(['id', 'title', 'icon', 'color', 'priority'])
            ->where('user_id', Auth::id())
            ->active()
            ->where('title', 'like', "%{$this->query}%")
            ->limit(5)
            ->get();

        $tasks = Task::query()
            ->select(['tasks.id', 'tasks.title', 'tasks.status', 'tasks.priority', 'tasks.project_id'])
            ->join('projects', 'projects.id', '=', 'tasks.project_id')
            ->where('projects.user_id', Auth::id())
            ->whereNull('projects.archived_at')
            ->where(function ($q) {
                $q->where('tasks.title', 'like', "%{$this->query}%")
                  ->orWhere('tasks.description', 'like', "%{$this->query}%");
            })
            ->with(['project:id,title,color'])
            ->limit(10)
            ->get();

        return [
            'projects' => $projects,
            'tasks' => $tasks,
        ];
    }

    // ─────────────────────────────────────────────────────────────
    // Actions
    // ─────────────────────────────────────────────────────────────

    #[On('open-global-search')]
    public function openSearch(): void
    {
        $this->open = true;
        $this->query = '';
    }

    public function close(): void
    {
        $this->open = false;
        $this->query = '';
    }

    public function selectProject(int $projectId): void
    {
        $this->dispatch('project-selected', projectId: $projectId);
        $this->close();
    }

    public function selectTask(int $taskId): void
    {
        // First, get the task's project to select it
        $task = Task::find($taskId);
        if ($task) {
            $this->dispatch('project-selected', projectId: $task->project_id);
            // Small delay to let project load, then open task details
            $this->dispatch('open-task-details', taskId: $taskId);
        }
        $this->close();
    }

    // ─────────────────────────────────────────────────────────────
    // Render
    // ─────────────────────────────────────────────────────────────

    public function render(): View
    {
        return view('livewire.global-search');
    }
}
