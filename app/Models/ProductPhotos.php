<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Storage;

class ProductPhotos extends Model
{
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
     * @return mixed
     */
    public function getThumbnailUrl()
    {
        return Storage::disk('public')->url('images/' . $this->thumbnail);
    }

    /**
     * @return mixed
     */
    public function getOriginUrl()
    {
        return Storage::disk('public')->url('images/' . $this->origin);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function scopeRemove(): void
    {
        if (Storage::disk('public')->exists('images/' . $this->thumbnail) === true) Storage::disk('public')->delete('images/' . $this->thumbnail);
        if (Storage::disk('public')->exists('images/' . $this->origin) === true) Storage::disk('public')->delete('images/' . $this->origin);

        $this->delete();
    }
}
