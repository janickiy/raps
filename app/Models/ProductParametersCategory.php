<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductParametersCategory extends Model
{
    protected $table = 'product_parameters_category';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
    ];

    /**
     * @return mixed
     */
    public static function getOption()
    {
        return self::orderBy('name')->get()->pluck('name', 'id');
    }
}
