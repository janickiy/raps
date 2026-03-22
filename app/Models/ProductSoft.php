<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSoft extends Model
{
    protected $table = 'product_soft';

    protected $fillable = [
        'url',
        'description',
        'product_id'
    ];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function scopeRemove(): void
    {
        $this->delete();
    }
}
