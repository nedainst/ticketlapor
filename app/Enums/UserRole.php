<?php

namespace App\Enums;

enum UserRole: string
{
    case MASYARAKAT = 'masyarakat';
    case ADMIN = 'admin';
    case SUPER_ADMIN = 'super_admin';

    public function label(): string
    {
        return match ($this) {
            self::MASYARAKAT => 'Masyarakat',
            self::ADMIN => 'Admin',
            self::SUPER_ADMIN => 'Super Admin',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::MASYARAKAT => 'sky',
            self::ADMIN => 'indigo',
            self::SUPER_ADMIN => 'violet',
        };
    }

    public function bgClass(): string
    {
        return match ($this) {
            self::MASYARAKAT => 'bg-sky-100 text-sky-700 dark:bg-sky-900/30 dark:text-sky-400',
            self::ADMIN => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400',
            self::SUPER_ADMIN => 'bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400',
        };
    }
}
