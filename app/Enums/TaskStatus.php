<?php

declare(strict_types=1);

namespace App\Enums;

enum TaskStatus: string
{
    case Todo = 'todo';
    case Doing = 'doing';
    case Done = 'done';

    public function label(): string
    {
        return match ($this) {
            self::Todo => 'To Do',
            self::Doing => 'In Progress',
            self::Done => 'Done',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Todo => 'text-slate-400',
            self::Doing => 'text-blue-400',
            self::Done => 'text-emerald-400',
        };
    }

    public function bgColor(): string
    {
        return match ($this) {
            self::Todo => 'bg-slate-400/10',
            self::Doing => 'bg-blue-400/10',
            self::Done => 'bg-emerald-400/10',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Todo => 'circle',
            self::Doing => 'circle-dot',
            self::Done => 'circle-check',
        };
    }
}
