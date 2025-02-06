<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'creator_id',
        'group_id',
        'priority',
        'status',
        'due_date',
        'assigned_users',
        'user_id'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function assignees()
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user');
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
