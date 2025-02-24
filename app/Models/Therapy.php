<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Therapy extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'name',
        'file',
        'user_id',
        'album_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'patient_therapy');
    }
}
