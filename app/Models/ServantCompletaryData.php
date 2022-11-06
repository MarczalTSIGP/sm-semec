<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServantCompletaryData extends Model
{
    use HasFactory;

    protected $table = 'servant_completary_datas';
    /**
    * @var array
    */
    protected $fillable = [
        'observation',
        'formation_id',
        'contract_id',
        'workload_id',
    ];

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class, 'formation_id');
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function moviments()
    {
        return $this->hasMany(Movement::class, 'servant_completary_data_id');
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function workload()
    {
        return $this->belongsTo(Workload::class, 'workload_id');
    }
}
