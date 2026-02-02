<?php

namespace App\Models;

use App\Http\Traits\StaticTableName;
use Illuminate\Database\Eloquent\Model;

class ProductParametersCategory extends Model
{
    protected $table = 'product_parameters_category';

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
