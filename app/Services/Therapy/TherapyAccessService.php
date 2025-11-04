<?php

namespace App\Services\Therapy;

use App\Models\Therapy;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class TherapyAccessService
{
    /**
     * Get therapies based on user's role.
     *
     * @param User|null $user If null, uses authenticated user
     * @param int $perPage Number of items per page
     * @return LengthAwarePaginator
     */
    public function getTherapiesForUser(?User $user = null, int $perPage = 15): LengthAwarePaginator
    {
        $user = $user ?? Auth::user();

        if (!$user) {
            return Therapy::with(['album', 'user', 'patients'])->paginate(0);
        }

        // Admin sees all therapies
        if ($user->hasRole('Admin')) {
            return Therapy::with(['album', 'user', 'patients'])->paginate($perPage);
        }

        // Doctor sees only their own therapies
        if ($user->hasRole('Doctor')) {
            $doctor = $user->doctor;
            if (!$doctor) {
                return Therapy::with(['album', 'user', 'patients'])->paginate(0);
            }
            return Therapy::where('user_id', $user->id)
                ->with(['album', 'patients'])
                ->paginate($perPage);
        }

        // Patient sees only assigned therapies
        if ($user->hasRole('Patient')) {
            $patient = $user->patient;
            if (!$patient) {
                return Therapy::with(['album', 'user'])->paginate(0);
            }
            return $patient->therapies()
                ->with(['album', 'user'])
                ->paginate($perPage);
        }

        return Therapy::with(['album', 'user', 'patients'])->paginate(0);
    }

    /**
     * Get all therapies for user without pagination (for API).
     *
     * @param User|null $user If null, uses authenticated user
     * @return Collection
     */
    public function getAllTherapiesForUser(?User $user = null): Collection
    {
        $user = $user ?? Auth::user();

        if (!$user) {
            return new Collection();
        }

        // Admin sees all therapies
        if ($user->hasRole('Admin')) {
            return Therapy::with(['album', 'user', 'patients'])->get();
        }

        // Doctor sees only their own therapies
        if ($user->hasRole('Doctor')) {
            $doctor = $user->doctor;
            if (!$doctor) {
                return new Collection();
            }
            return Therapy::where('user_id', $user->id)
                ->with(['album', 'patients'])
                ->get();
        }

        // Patient sees only assigned therapies
        if ($user->hasRole('Patient')) {
            $patient = $user->patient;
            if (!$patient) {
                return new Collection();
            }
            return $patient->therapies()
                ->with(['album', 'user'])
                ->get();
        }

        return new Collection();
    }

    /**
     * Check if user can access a specific therapy.
     *
     * @param User $user
     * @param Therapy $therapy
     * @return bool
     */
    public function canAccessTherapy(User $user, Therapy $therapy): bool
    {
        // Admin can access all therapies
        if ($user->hasRole('Admin')) {
            return true;
        }

        // Doctor can access their own therapies
        if ($user->hasRole('Doctor')) {
            return $therapy->user_id === $user->id;
        }

        // Patient can access assigned therapies
        if ($user->hasRole('Patient')) {
            $patient = $user->patient;
            if (!$patient) {
                return false;
            }
            return $therapy->patients()->where('patient_id', $patient->id)->exists();
        }

        return false;
    }

    /**
     * Assign therapy to patient(s).
     *
     * @param Therapy $therapy
     * @param Patient|array $patients Single patient or array of patient IDs
     * @return void
     */
    public function assignTherapyToPatients(Therapy $therapy, $patients): void
    {
        if ($patients instanceof Patient) {
            // Single patient instance
            $therapy->patients()->syncWithoutDetaching([$patients->id]);
        } elseif (is_array($patients)) {
            // Array of patient IDs
            $therapy->patients()->syncWithoutDetaching($patients);
        } elseif (is_numeric($patients)) {
            // Single patient ID
            $therapy->patients()->syncWithoutDetaching([$patients]);
        }
    }

    /**
     * Remove therapy assignment from patient(s).
     *
     * @param Therapy $therapy
     * @param Patient|array $patients Single patient or array of patient IDs
     * @return void
     */
    public function removeTherapyFromPatients(Therapy $therapy, $patients): void
    {
        if ($patients instanceof Patient) {
            $therapy->patients()->detach($patients->id);
        } elseif (is_array($patients)) {
            $therapy->patients()->detach($patients);
        } elseif (is_numeric($patients)) {
            $therapy->patients()->detach($patients);
        }
    }

    /**
     * Get all patients assigned to a therapy.
     *
     * @param Therapy $therapy
     * @return Collection
     */
    public function getAssignedPatients(Therapy $therapy): Collection
    {
        return $therapy->patients()->with('user')->get();
    }

    /**
     * Check if therapy is assigned to any patients.
     *
     * @param Therapy $therapy
     * @return bool
     */
    public function hasAssignedPatients(Therapy $therapy): bool
    {
        return $therapy->patients()->exists();
    }

    /**
     * Get count of patients assigned to therapy.
     *
     * @param Therapy $therapy
     * @return int
     */
    public function getAssignedPatientsCount(Therapy $therapy): int
    {
        return $therapy->patients()->count();
    }
}
