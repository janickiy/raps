<?php

namespace App\Models;

use App\Http\Traits\StaticTableName;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    use StaticTableName;

    protected $table = 'seo';

    protected $fillable = [
        'type',
        'h1',
        'title',
        'keyword',
        'description',
        'url_canonical',
    ];
}
