<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductParameters extends Model
{
    protected $table = 'product_parameters';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'value',
        'product_id',
        'category_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Products::class,'product_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ProductParametersCategory::class, 'category_id', 'id');
    }
}
