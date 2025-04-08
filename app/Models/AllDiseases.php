<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class AllDiseases extends Model
{
    use HasFactory;

    public function patients()
    {
        return $this->morphedByMany(Patient::class, 'diseasable', 'patient_diseases');
    }

    public function getTranslatedName()
    {
        $locale = App::getLocale();
        return $this->name[$locale] ?? $this->name['en'] ?? '';
    }
}
