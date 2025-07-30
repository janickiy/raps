<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Storage;

class ProductSoft extends Model
{
    protected $table = 'product_soft';

    protected $fillable = [
        'path',
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
     * @return mixed
     */
    public function getDocument()
    {
        return Storage::disk('public')->url('soft/' . $this->path);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function scopeRemove(): void
    {
        if (Storage::disk('public')->exists('soft/' . $this->path) === true) Storage::disk('public')->delete('soft/' . $this->path);

        $this->delete();
    }
}
