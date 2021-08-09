<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
     'name',
    ];

    /**
     * @param string $term
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
    */
    public static function search($term)
    {
        if ($term) {
            $searchTerm = "%{$term}%";
            return Role::where('name', 'LIKE', $searchTerm)
                ->orderBy('name', 'asc')
                ->paginate(20);
        }
        return Role::orderBy('name', 'asc')->paginate(20);
    }
}
