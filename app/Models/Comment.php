<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = [
        'nld_id',
        'comment',
        'user_id',
    ];

    /**
     * Get the NLD associated with the comment.
     */
    public function nld(): BelongsTo
    {
        return $this->belongsTo(Nld::class);
    }

    /**
     * Get the user who wrote the comment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
