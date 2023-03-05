<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UnitCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'category_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(UnitCategory::class, 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function inscriptions()
    {
        return $this->belongsToMany(Inscription::class, 'inscription_units', 'inscription_id', 'unit_id');
    }

    /**
     * @param string $term
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public static function search($term)
    {
        if ($term) {
            $searchTerm = "%{$term}%";
            return Unit::query()->with(['category'])
                ->where('name', 'LIKE', $searchTerm)
                ->orderBy('name', 'desc')
                ->paginate(20);
        }
        return Unit::with(['category'])->orderBy('name', 'desc')->paginate(20);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function moviments()
    {
        return $this->hasMany(Movement::class, 'unit_id');
    }
}
