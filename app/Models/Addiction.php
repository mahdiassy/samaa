<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addiction extends AllDiseases
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected $casts = [
        'name' => 'array',
    ];
}
