<?php

namespace App\Models;

use App\Http\Traits\StaticTableName;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use StaticTableName;

    protected $table = 'faq';

    protected $fillable = [
        'question',
        'answer',
    ];
}
