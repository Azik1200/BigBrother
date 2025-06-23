<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'catalog_id',
        'name',
    ];

    /**
     * Catalog that this category belongs to.
     */
    public function catalog(): BelongsTo
    {
        return $this->belongsTo(Catalog::class);
    }
}
