<?php

namespace App\Models;

use App\Http\Traits\File;
use App\Http\Traits\StaticTableName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPhotos extends Model
{
    use StaticTableName, File;

    protected $table = 'product_photos';

    protected $fillable = [
        'title',
        'alt',
        'thumbnail',
        'origin',
        'product_id'
    ];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class,'product_id','id');
    }

    /**
     * @return string|null
     */
    public function getThumbnailUrl(): ?string
    {
        return $this->thumbnail ? self::getFile($this->thumbnail, $this->table) : null;
    }

    /**
     * @return string|null
     */
    public function getOriginUrl(): ?string
    {
        return $this->origin ? self::getFile($this->origin, $this->table) : null;
    }

    /**
     * @return void
     */
    public function scopeRemove(): void
    {
        self::deleteFile($this->thumbnail, $this->table);
        self::deleteFile($this->origin, $this->table);

        $this->delete();
    }
}
