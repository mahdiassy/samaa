<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class PatientDisease extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'diseasable_id',
        'diseasable_type',
        'medications'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class ,'patient_id');
    }

    public function disease()
    {
        return $this->belongsTo(Disease::class,'disease_id');
    }
}
