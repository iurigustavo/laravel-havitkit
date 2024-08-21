<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @property string $handle
 * @property array $items
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Menu extends Model
{
    use LogsActivity;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'items' => 'json',
        ];
    }

    public static function fromHandle(string $handle): ?static
    {
        return static::query()->firstWhere('handle', $handle);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }
}
