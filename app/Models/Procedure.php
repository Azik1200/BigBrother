<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    protected $fillable = [
        'name',       // Название процедуры
        'file_path',  // Путь к файлу процедуры
        'group_id',    // ID пользователя, загрузившего процедуру
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

}
