<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Storage;

class ProductDocuments extends Model
{
    protected $table = 'product_documents';

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
        return Storage::disk('public')->url('documents/' . $this->path);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function scopeRemove(): void
    {
        if (Storage::disk('public')->exists('documents/' . $this->path) === true) Storage::disk('public')->delete('documents/' . $this->path);

        $this->delete();
    }
}
