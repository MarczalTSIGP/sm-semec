<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inscription extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'edict_id',
        'servant_id',
        'contract_id',
        'removal_type_id',
        'reason',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function servant()
    {
        return $this->belongsTo(Servant::class, 'servant_id');
    }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currentUnit()
    {
        return $this->belongsTo(Unit::class, 'current_unit_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function edict()
    {
        return $this->belongsTo(Edict::class, 'edict_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function removalType()
    {
        return $this->belongsTo(RemovalType::class, 'removal_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function interestedUnits()
    {
        return $this->belongsToMany(Unit::class, 'inscription_units', 'inscription_id', 'unit_id');
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function classifications()
    {
        return $this->hasMany(Classification::class, 'inscription_id');
    }
}
