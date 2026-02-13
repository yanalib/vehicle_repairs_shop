<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    protected $fillable = [
        'vehicle_id',
        'description',
        'status',
        'started_at',
        'finished_at',
        'total_cost',
        'is_paid',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
