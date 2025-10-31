<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'first_name',
        'last_name',
        'image',
        'phone',
        'address',
        'birthday',
        'twitter',
        'facebook',
        'instagram',
        'blood_type',
        'gender',
        'user_id',
        /*'therapeutic_area_id',
        'disease_id',
        'psychological_id',*/
        'country_id',
        'language_id',
        'open_description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function diseases()
    {
        return $this->morphedByMany(Disease::class, 'diseasable', 'patient_diseases');
    }

    public function addictiones()
    {
        return $this->morphedByMany(Addiction::class, 'diseasable', 'patient_diseases');
    }

    public function consultationes()
    {
        return $this->morphedByMany(Consultation::class, 'diseasable', 'patient_diseases');
    }

    public function incidents()
    {
        return $this->morphedByMany(Incident::class, 'diseasable', 'patient_diseases');
    }

    public function psychologicals()
    {
        return $this->morphedByMany(Psychological::class, 'diseasable', 'patient_diseases');
    }

    public function symptomes()
    {
        return $this->morphedByMany(Symptom::class, 'diseasable', 'patient_diseases');
    }

    public function therapeutic_areas()
    {
        return $this->morphedByMany(Therapeutic_area::class, 'diseasable', 'patient_diseases');
    }

    public function nervouses()
    {
        return $this->morphedByMany(Nervous::class, 'diseasable', 'patient_diseases');
    }

    public function therapies()
    {
        return $this->belongsToMany(Therapy::class, 'patient_therapy');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'patient_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'patient_id');
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getAgeAttribute()
    {
        return $this->birthday ? \Carbon\Carbon::parse($this->birthday)->age : null;
    }
}
