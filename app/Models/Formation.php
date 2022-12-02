<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Formation extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'formation_name',
        'score_formation',
    ];

    public function servantCompletaryData()
    {
        return $this->hasOne(ServantCompletaryData::class);
    }
}
