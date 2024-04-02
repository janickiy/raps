<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductParameters extends Model
{
    protected $table = 'product_parameters';

    protected $fillable = [
        'name',
        'value',
        'product_id',
        'category_id',
    ];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class,'product_id','id');
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductParametersCategory::class, 'category_id', 'id');
    }
}
