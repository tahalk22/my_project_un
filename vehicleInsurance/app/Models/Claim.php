<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    protected $guarded = [] ;



            public function scopeFilter($query, $filters)
        {
            return $query
                ->when($filters['insurance_id'] ?? false, fn($q, $value) => $q->where('insurance_id', $value))
                ->when($filters['date_from'] ?? false, fn($q, $value) => $q->whereDate('claim_date', '>=', $value))
                ->when($filters['date_to'] ?? false, fn($q, $value) => $q->whereDate('claim_date', '<=', $value))
                ->when($filters['claim_status'] ?? false, fn($q, $value) => $q->where('claim_status', $value));
        }

       
        public function insurance()
        {
            return $this->belongsTo(Insurance::class);
        }

}
