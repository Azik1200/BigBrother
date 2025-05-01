<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Nld extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'issue_key',
        'group_id',
        'summary',
        'description',
        'reporter_name',
        'issue_type',
        'updated',
        'created',
        'parent_issue_key',
        'parent_issue_status',
        'parent_issue_number',
        'control_status',
        'add_date',
        'send_date',
        'done_date',
    ];

    /**
     * Комментарии, связанные с данным NLD.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Группа, к которой принадлежит NLD.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_nld');
    }
}
