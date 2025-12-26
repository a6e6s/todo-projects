<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Priority;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'icon',
        'color',
        'sort_order',
        'priority',
        'archived_at',
    ];

    protected function casts(): array
    {
        return [
            'priority' => Priority::class,
            'sort_order' => 'integer',
            'archived_at' => 'datetime',
        ];
    }

    // ─────────────────────────────────────────────────────────────
    // Relationships
    // ─────────────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    // ─────────────────────────────────────────────────────────────
    // Scopes
    // ─────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->whereNull('archived_at');
    }

    public function scopeArchived($query)
    {
        return $query->whereNotNull('archived_at');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    // ─────────────────────────────────────────────────────────────
    // Accessors & Helpers
    // ─────────────────────────────────────────────────────────────

    public function isArchived(): bool
    {
        return $this->archived_at !== null;
    }
}
