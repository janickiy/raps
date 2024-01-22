<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

class ProductPhotos extends Model
{
    protected $table = 'product_photos';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'alt',
        'thumbnail',
        'origin',
        'product_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
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
}
