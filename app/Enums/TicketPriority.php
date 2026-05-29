<?php

namespace App\Enums;

enum TicketPriority: string
{
    case RENDAH = 'rendah';
    case SEDANG = 'sedang';
    case TINGGI = 'tinggi';
    case DARURAT = 'darurat';

    public function label(): string
    {
        return match ($this) {
            self::RENDAH => 'Rendah',
            self::SEDANG => 'Sedang',
            self::TINGGI => 'Tinggi',
            self::DARURAT => 'Darurat',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::RENDAH => 'slate',
            self::SEDANG => 'blue',
            self::TINGGI => 'orange',
            self::DARURAT => 'red',
        };
    }

    public function bgClass(): string
    {
        return match ($this) {
            self::RENDAH => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300',
            self::SEDANG => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
            self::TINGGI => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
            self::DARURAT => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::RENDAH => 'minus-circle',
            self::SEDANG => 'information-circle',
            self::TINGGI => 'exclamation-triangle',
            self::DARURAT => 'fire',
        };
    }

    public function level(): int
    {
        return match ($this) {
            self::RENDAH => 1,
            self::SEDANG => 2,
            self::TINGGI => 3,
            self::DARURAT => 4,
        };
    }
}
