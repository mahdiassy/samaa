<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Therapeutic_area extends AllDiseases
{
    use HasFactory;

    public $table = 'therapeutic_areas';

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'name' => 'array',
    ];
}
