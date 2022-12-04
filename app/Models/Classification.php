<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classification extends Model
{
    use HasFactory;

    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Classification::class;

    public $timestamps = false;

    protected $fillable = [
        'rank',
        'worked_days',
        'formation_points',
        'worked_days_unit',
        'inscription_id',
        'edict_id',

    ];


    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function inscription()
    {
        return $this->belongsTo(Inscription::class, 'inscription_id');
    }

     /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function edict()
    {
        return $this->belongsTo(Edict::class, 'edict_id');
    }
}
