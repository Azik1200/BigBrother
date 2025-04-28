<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'priority',
        'status',
        'due_date',
        'user_id', // Автор задачи
        'group_id', // Основная группа (если есть)
    ];

    /**
     * Автор задачи.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Пользователи, назначенные на задачу (ассайни).
     */
    public function assignees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id');
    }

    /**
     * Группа, напрямую связанная с задачей.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    /**
     * Группы через pivot (многие ко многим).
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_task', 'task_id', 'group_id');
    }

    /**
     * Файлы, прикреплённые к задаче.
     */
    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

    /**
     * Комментарии к задаче.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
