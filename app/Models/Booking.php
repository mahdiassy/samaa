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

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function availability()
    {
        return $this->belongsTo(Availability::class, 'available_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Accessors
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => __('site.Pending'),
            'approved' => __('site.Approved'),
            'rejected' => __('site.Rejected'),
        ];
        return $labels[$this->status] ?? $this->status;
    }
}
