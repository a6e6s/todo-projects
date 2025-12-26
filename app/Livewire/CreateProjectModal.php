<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Enums\Priority;
use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateProjectModal extends Component
{
    public bool $open = false;

    #[Validate('required|string|min:2|max:100')]
    public string $title = '';

    public string $icon = '';
    public string $color = '#3b82f6';
    public string $priority = 'medium';

    public array $iconOptions = ['📁', '🚀', '💼', '🎯', '📊', '🔧', '💡', '🎨', '📱', '🌐', '⭐', '🔥'];
    public array $colorOptions = ['#3b82f6', '#8b5cf6', '#ec4899', '#ef4444', '#f97316', '#eab308', '#22c55e', '#14b8a6', '#06b6d4', '#6366f1'];

    // ─────────────────────────────────────────────────────────────
    // Actions
    // ─────────────────────────────────────────────────────────────

    #[On('open-create-project-modal')]
    public function openModal(): void
    {
        $this->reset(['title', 'icon', 'priority']);
        $this->color = '#3b82f6';
        $this->open = true;
    }

    public function create(): void
    {
        $this->validate();

        $maxOrder = Project::where('user_id', Auth::id())->max('sort_order') ?? 0;

        $project = Project::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'icon' => $this->icon ?: null,
            'color' => $this->color,
            'priority' => $this->priority,
            'sort_order' => $maxOrder + 1,
        ]);

        $this->close();

        // Refresh sidebar and select new project
        $this->dispatch('project-created');
        $this->dispatch('project-selected', projectId: $project->id);
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
        return view('livewire.create-project-modal');
    }
}
