<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

class ProductDocuments extends Model
{
    protected $table = 'product_documents';

    protected $primaryKey = 'id';

    protected $fillable = [
        'path',
        'description',
        'product_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }

    /**
     * @return mixed
     */
    public function getDocument()
    {
        return Storage::disk('public')->url('app/public/documents/' . $this->path);
    }
}
