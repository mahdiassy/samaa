<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    protected $fillable = [
        'time',
        'doctor_id',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function booking()
    {
        return $this->hasOne(Booking::class,'available_id');
    }
}
