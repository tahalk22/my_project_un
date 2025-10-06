<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Clause extends Model
{
    protected $guarded = [] ;




    public function scopeFilter(Builder $query, $filters)
{
    $query->when($filters['name'] ?? null, fn($q, $value) =>
        $q->where('name', 'like', "%$value%")
    );

    $query->when($filters['type'] ?? null, fn($q, $value) =>
        $q->where('type', $value)
    );
}

}
