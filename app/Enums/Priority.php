<?php

declare(strict_types=1);

namespace App\Enums;

enum Priority: string
{
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';

    public function label(): string
    {
        return match ($this) {
            self::Low => 'Low',
            self::Medium => 'Medium',
            self::High => 'High',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Low => 'text-emerald-400',
            self::Medium => 'text-amber-400',
            self::High => 'text-rose-400',
        };
    }

    public function bgColor(): string
    {
        return match ($this) {
            self::Low => 'bg-emerald-400/10',
            self::Medium => 'bg-amber-400/10',
            self::High => 'bg-rose-400/10',
        };
    }
}
