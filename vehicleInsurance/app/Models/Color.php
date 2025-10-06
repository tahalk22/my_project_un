<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $guarded = [] ;

    public function scopeFilter($query, $filters)
{
    $query->when($filters['name'] ?? null, function ($q, $value) {
        $q->where('name', 'like', "%{$value}%");
    });
}

}
