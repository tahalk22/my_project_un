<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
     
    protected $guarded = [] ;




    public function scopeFilter($query, $filters)
{
    if (!empty($filters['search'])) {
        $query->where('office_name', 'like', '%' . $filters['search'] . '%');
    }

    return $query;
}


    public function city()
{
    return $this->belongsTo(City::class);
}
public function insurances()
{
    return $this->hasMany(\App\Models\Insurance::class);
}



}
