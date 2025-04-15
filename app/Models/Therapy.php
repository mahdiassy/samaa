<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public static function getTherapiesBasedRole()
    {
        $therapies = collect();
        if (auth()->user()->hasRole('Admin')) {
            $therapies = Therapy::paginate(9);
        } elseif (auth()->user()->hasRole('Doctor')) {
            $therapies = Therapy::where('user_id', Auth::id())
                ->orWhereHas('user', function ($query) {
                    $query->whereHas('roles', function ($roleQuery) {
                        $roleQuery->where('name', 'Admin');
                    });
                })
                ->paginate(9);
        } elseif (auth()->user()->hasRole('Patient')) {
            $user = Patient::where('user_id', Auth::id())->first();
            $therapyIds = DB::table('patient_therapy')
                ->where('patient_id', $user->id)
                ->pluck('therapy_id');

            $therapies = Therapy::whereIn('id', $therapyIds)
                ->orWhereHas('user', function ($query) {
                    $query->whereHas('roles', function ($roleQuery) {
                        $roleQuery->where('name', 'Admin');
                    });
                })->paginate(9);

        }
        return $therapies;
    }

}
