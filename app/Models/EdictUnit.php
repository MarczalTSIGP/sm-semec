<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EdictUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'edict_id',
        'unit_id',
        'available_vacancies',
        'type_of_vacancy',
        'servants_ids',
    ];

    protected $table = 'edict_units';
}
