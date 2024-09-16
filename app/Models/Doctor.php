<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'first_name','last_name','image','phone','address','twitter','facebook','instagram','birthday','user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
