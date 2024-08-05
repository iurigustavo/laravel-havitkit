<?php

namespace App\Enums;

enum TaskStatusEnum: string
{
    case TODO     = 't.todo';
    case PROGRESS = 't.prg';
    case DONE     = 't.done';

    public static function statusOpen(): array
    {
        return [self::TODO->value, self::PROGRESS->value];
    }

    public static function statusClosed(): array
    {
        return [self::DONE->value];
    }

    public static function toArray(): array
    {
        return [
            self::TODO,
            self::PROGRESS,
            self::DONE,
        ];
    }

    public function text(): string
    {
        return match ($this) {
            self::TODO => 'Todo',
            self::PROGRESS => 'In Progress',
            self::DONE => 'Done',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::TODO => '<span class="badge badge-light-danger">Todo</span>',
            self::PROGRESS => '<span class="badge badge-light-primary">In Progress</span>',
            self::DONE => '<span class="badge badge-light-success">Done</span>',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::TODO => 'danger',
            self::PROGRESS => 'primary',
            self::DONE => 'success',
        };
    }
}
