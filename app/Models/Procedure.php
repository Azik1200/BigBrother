<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Procedure extends Model
{
    protected $fillable = [
        'name',        // Название процедуры
        'file_path',   // Путь к файлу процедуры
        'group_id',    // ID группы, связанной с процедурой
    ];

    /**
     * Группа, к которой принадлежит процедура.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
