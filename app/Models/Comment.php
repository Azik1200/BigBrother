<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['nld_id', 'comment', 'user_id']; // Заменили task_id на nld_id

    // Связь с Nld
    public function nld()
    {
        return $this->belongsTo(Nld::class); // Связь с моделью Nld
    }

    // Связь с User
    public function user()
    {
        return $this->belongsTo(User::class); // Связь с моделью User
    }
}
