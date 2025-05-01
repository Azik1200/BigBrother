<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NldGroupStatus extends Model
{
    protected $fillable = ['nld_id', 'group_id', 'done_at'];

    public function group() {
        return $this->belongsTo(Group::class);
    }

    public function nld() {
        return $this->belongsTo(Nld::class);
    }
}
