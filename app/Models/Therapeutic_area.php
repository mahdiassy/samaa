<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Therapeutic_area extends Model
{
    use HasFactory;

    public $table = 'therapeutic_areas';

    protected $fillable = [
        'name',
    ];

    /*public function diseases()
    {
        return $this->hasMany(Disease::class);
    }*/

}
