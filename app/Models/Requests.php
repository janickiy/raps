<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    const CALCULATION_TYPE = 1;
    const QUESTIONNAIRE_TYPE = 2;

    protected $table = 'requests';

    protected $fillable = [
        'type',
        'path',
        'ip',
    ];

    public static $type_name = [
        self::CALCULATION_TYPE => 'Заявка на расчет проекта',
        self::QUESTIONNAIRE_TYPE => 'Опросный лист',
    ];
}
