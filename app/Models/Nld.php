<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}

