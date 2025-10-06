<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
     

    protected $guarded = [] ;



    public function scopeFilter($query, $filters)
{
    $query->when($filters['insurance_name'] ?? null, fn($q, $val) =>
        $q->where('insurance_name', 'like', "%$val%")
    );

    $query->when($filters['from_date'] ?? null, fn($q, $val) =>
        $q->whereDate('version_date', '>=', $val)
    );

    $query->when($filters['to_date'] ?? null, fn($q, $val) =>
        $q->whereDate('version_date', '<=', $val)
    );

    $query->when($filters['office_id'] ?? null, fn($q, $val) =>
        $q->where('office_id', $val)
    );

    $query->when($filters['user_id'] ?? null, fn($q, $val) =>
    $q->where('user_id', $val)
);

}

        public function country()
        {
            return $this->belongsTo(Country::class, 'country_id');
        }

        public function car_type()
        {
            return $this->belongsTo(CarType::class, 'car_type_id');
        }

        public function clause()
        {
            return $this->belongsTo(Clause::class, 'clause_id');
        }

        public function color()
        {
            return $this->belongsTo(Color::class, 'color_id');
        }

        public function user()
        {
            return $this->belongsTo(User::class, 'user_id');
        }
        public function office()
        {
            return $this->belongsTo(Office::class, 'office_id');
        }

        public function claims()
        {
            return $this->hasMany(\App\Models\Claim::class);
        }







}
