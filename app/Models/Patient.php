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
        'user_id'
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
}
