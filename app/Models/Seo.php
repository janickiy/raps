<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
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
