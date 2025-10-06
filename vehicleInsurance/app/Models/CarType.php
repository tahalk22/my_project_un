<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarType extends Model
{
    protected $guarded = [] ;


    public function scopeFilter($query, $filters)
        {
            $query->when($filters['name'] ?? null, fn($q, $val) =>
                $q->where('name', 'like', "%$val%")
            );

            $query->when($filters['country_id'] ?? null, fn($q, $val) =>
                $q->where('country_id', $val)
            );
        }

        public function country()
        {
            return $this->belongsTo(\App\Models\Country::class, 'country_id');
        }


}
