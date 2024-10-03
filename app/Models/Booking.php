<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'available_id',
        'status',
        'reason',
    ];

    public function availability()
    {
        return $this->belongsTo(Availability::class, 'available_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
