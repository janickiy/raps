<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetectedGases extends Model
{
    protected $table = 'detected_gases';

    protected $fillable = [
        'name',
        'formula',
        'volume_fraction',
        'product_id'
    ];
    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
}
