<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\DateTimeFormatter;
use Carbon\Carbon;

class Movement extends Model
{
    use DateTimeFormatter;
    use HasFactory;

    protected $fillable = [
        'period',
        'occupation',
        'started_at',
        'ended_at',
        'unit_id',
        'servant_completary_data_id',
    ];

    protected $dates = [
        'started_at',
        'ended_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function servantCompletaryData()
    {
        return $this->belongsTo(ServantCompletaryData::class, 'servant_completary_data_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
