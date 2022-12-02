<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EdictUnit extends Model
{
    use HasFactory;

    /**
     * @var array
    */
    protected $fillable = [
        'edict_id',
        'unit_id',
        'number_vacancies',
        'type_of_vacancy',
        'servants_id'
    ];

    protected $table = 'edict_units';
}
