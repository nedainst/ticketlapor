<?php

namespace App\Enums;

enum TicketStatus: string
{
    case PENDING = 'pending';
    case DIPROSES = 'diproses';
    case MENUNGGU_BALASAN = 'menunggu_balasan';
    case SELESAI = 'selesai';
    case DITOLAK = 'ditolak';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::DIPROSES => 'Diproses',
            self::MENUNGGU_BALASAN => 'Menunggu Balasan',
            self::SELESAI => 'Selesai',
            self::DITOLAK => 'Ditolak',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'amber',
            self::DIPROSES => 'blue',
            self::MENUNGGU_BALASAN => 'purple',
            self::SELESAI => 'emerald',
            self::DITOLAK => 'red',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::PENDING => 'clock',
            self::DIPROSES => 'arrow-path',
            self::MENUNGGU_BALASAN => 'chat-bubble-left-ellipsis',
            self::SELESAI => 'check-circle',
            self::DITOLAK => 'x-circle',
        };
    }

    public function bgClass(): string
    {
        return match ($this) {
            self::PENDING => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400',
            self::DIPROSES => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
            self::MENUNGGU_BALASAN => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
            self::SELESAI => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400',
            self::DITOLAK => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
        };
    }
}
