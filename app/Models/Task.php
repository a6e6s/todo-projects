<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Priority;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'assigned_to',
        'title',
        'description',
        'priority',
        'status',
        'sort_order',
        'due_date',
        'effort_score',
    ];

    protected function casts(): array
    {
        return [
            'priority' => Priority::class,
            'status' => TaskStatus::class,
            'sort_order' => 'integer',
            'due_date' => 'date',
            'effort_score' => 'integer',
        ];
    }

    // ─────────────────────────────────────────────────────────────
    // Relationships
    // ─────────────────────────────────────────────────────────────

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    // ─────────────────────────────────────────────────────────────
    // Scopes
    // ─────────────────────────────────────────────────────────────

    public function scopeTodo($query)
    {
        return $query->where('status', TaskStatus::Todo);
    }

    public function scopeDoing($query)
    {
        return $query->where('status', TaskStatus::Doing);
    }

    public function scopeDone($query)
    {
        return $query->where('status', TaskStatus::Done);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function scopeOverdue($query)
    {
        return $query->whereNotNull('due_date')
            ->where('due_date', '<', now())
            ->where('status', '!=', TaskStatus::Done);
    }

    public function scopeDueToday($query)
    {
        return $query->whereDate('due_date', today());
    }

    public function scopeUnassigned($query)
    {
        return $query->whereNull('assigned_to');
    }

    // ─────────────────────────────────────────────────────────────
    // Accessors & Helpers
    // ─────────────────────────────────────────────────────────────

    public function isOverdue(): bool
    {
        return $this->due_date !== null
            && $this->due_date->isPast()
            && $this->status !== TaskStatus::Done;
    }

    public function isDueToday(): bool
    {
        return $this->due_date?->isToday() ?? false;
    }

    public function isCompleted(): bool
    {
        return $this->status === TaskStatus::Done;
    }
}
