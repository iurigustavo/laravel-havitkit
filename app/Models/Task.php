<?php

namespace App\Models;

use App\Enums\TaskStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $attributes = ['status' => TaskStatusEnum::TODO];
    protected $fillable   = [
        'code',
        'title',
        'description',
        'status',
        'assignee_user_id',
        'reporter_user_id',
        'expires_at',
        'finished_at',
    ];

//    protected static function booted(): void
//    {
//        static::created(static function (Task $tarefa) {
//            $tarefa->update(['codigo' => GerarEdocAction::run($tarefa->id)]);
//        });
//    }


    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_user_id')->withDefault(['name' => 'System']);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_user_id')->withDefault(['name' => 'None']);
    }

    protected function casts(): array
    {
        return ['status' => TaskStatusEnum::class, '' => 'datetime', 'data_finalizado' => 'datetime'];
    }
}
