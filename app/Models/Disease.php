<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'therapeutic_area_id',
    ];

    public function therapeutic()
    {
        return $this->belongsTo(Therapeutic_area::class);
    }
}
