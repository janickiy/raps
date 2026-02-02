<?php

namespace App\Models;

use App\Http\Traits\File;
use App\Http\Traits\StaticTableName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductDocuments extends Model
{
    use StaticTableName, File;

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
     * @return string|null
     */
    public function getDocument(): ?string
    {
        return File::getFile($this->path, $this->table);
    }

    /**
     * @return void
     */
    public function scopeRemove(): void
    {
        if ($this->path)  File::deleteFile($this->path, $this->table);

        $this->delete();
    }
}
