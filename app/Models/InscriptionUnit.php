<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InscriptionUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'inscription_id', 'unit_id'
    ];

    protected $table = 'inscription_units';
}
