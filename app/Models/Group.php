<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'deleted_at',
        'deleted_by',
        'group_leader',
        'user_id',
    ];

    /**
     * Участники группы.
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_user', 'group_id', 'user_id');
    }

    /**
     * Пользователи группы (альтернативная связь).
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Задачи, связанные с группой (один ко многим).
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Много ко многим — задачи, связанные через pivot group_task.
     */
    public function tasksMany(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'group_task', 'group_id', 'task_id');
    }

    /**
     * Руководитель группы.
     */
    public function leader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'group_leader');
    }
}
