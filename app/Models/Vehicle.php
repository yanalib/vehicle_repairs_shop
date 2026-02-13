<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'reg_no',
        'make',
        'model',
        'year',
        'vin',
        'client_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function repairs()
    {
        return $this->hasMany(Repair::class);
    }
}
