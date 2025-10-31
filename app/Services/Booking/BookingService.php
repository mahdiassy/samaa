<?php

namespace App\Services\Booking;

use App\Models\Booking;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\User;
use App\Enums\BookingEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class BookingService
{
    /**
     * Create a new booking.
     *
     * @param array $data ['patient_id', 'doctor_id', 'booking_date', 'notes' (optional)]
     * @return Booking
     * @throws \Exception
     */
    public function createBooking(array $data): Booking
    {
        DB::beginTransaction();
        try {
            $booking = Booking::create([
                'patient_id' => $data['patient_id'],
                'doctor_id' => $data['doctor_id'],
                'booking_date' => $data['booking_date'],
                'notes' => $data['notes'] ?? null,
                'status' => BookingEnum::PENDING,
            ]);

            DB::commit();
            return $booking;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Approve a booking.
     *
     * @param Booking $booking
     * @return Booking
     * @throws \Exception
     */
    public function approveBooking(Booking $booking): Booking
    {
        DB::beginTransaction();
        try {
            $booking->update(['status' => BookingEnum::APPROVED]);

            DB::commit();
            return $booking->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Cancel a booking.
     *
     * @param Booking $booking
     * @param string|null $cancellationReason
     * @param bool $isByDoctor True if doctor cancels, false if patient cancels
     * @return Booking
     * @throws \Exception
     */
    public function cancelBooking(Booking $booking, ?string $cancellationReason = null, bool $isByDoctor = true): Booking
    {
        DB::beginTransaction();
        try {
            $booking->update([
                'status' => $isByDoctor ? BookingEnum::DOCTOR_CANCEL : BookingEnum::PATIENT_CANCEL,
                'notes' => $cancellationReason 
                    ? ($booking->notes ? $booking->notes . "\nCancellation: " . $cancellationReason : "Cancellation: " . $cancellationReason)
                    : $booking->notes,
            ]);

            DB::commit();
            return $booking->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Reschedule a booking.
     *
     * @param Booking $booking
     * @param string $newDate Format: 'Y-m-d H:i:s'
     * @return Booking
     * @throws \Exception
     */
    public function rescheduleBooking(Booking $booking, string $newDate): Booking
    {
        DB::beginTransaction();
        try {
            $booking->update(['booking_date' => $newDate]);

            DB::commit();
            return $booking->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Get bookings for a specific doctor.
     *
     * @param Doctor $doctor
     * @param string|null $status Filter by status (pending/approved/canceled)
     * @return Collection
     */
    public function getBookingsForDoctor(Doctor $doctor, ?string $status = null): Collection
    {
        $query = Booking::where('doctor_id', $doctor->id)
            ->with(['patient.user']);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderBy('booking_date', 'desc')->get();
    }

    /**
     * Get bookings for a specific patient.
     *
     * @param Patient $patient
     * @param string|null $status Filter by status (pending/approved/canceled)
     * @return Collection
     */
    public function getBookingsForPatient(Patient $patient, ?string $status = null): Collection
    {
        $query = Booking::where('patient_id', $patient->id)
            ->with(['doctor.user']);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderBy('booking_date', 'desc')->get();
    }

    /**
     * Get all bookings (for admin).
     *
     * @param string|null $status Filter by status
     * @return Collection
     */
    public function getAllBookings(?string $status = null): Collection
    {
        $query = Booking::with(['patient.user', 'doctor.user']);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderBy('booking_date', 'desc')->get();
    }

    /**
     * Get bookings based on user's role.
     *
     * @param User $user
     * @param string|null $status
     * @return Collection
     */
    public function getBookingsForUser(User $user, ?string $status = null): Collection
    {
        if ($user->hasRole('Admin')) {
            return $this->getAllBookings($status);
        }

        if ($user->hasRole('Doctor')) {
            $doctor = $user->doctor;
            if (!$doctor) {
                return new Collection();
            }
            return $this->getBookingsForDoctor($doctor, $status);
        }

        if ($user->hasRole('Patient')) {
            $patient = $user->patient;
            if (!$patient) {
                return new Collection();
            }
            return $this->getBookingsForPatient($patient, $status);
        }

        return new Collection();
    }

    /**
     * Check if user can manage a booking.
     *
     * @param User $user
     * @param Booking $booking
     * @return bool
     */
    public function canManageBooking(User $user, Booking $booking): bool
    {
        // Admin can manage all bookings
        if ($user->hasRole('Admin')) {
            return true;
        }

        // Doctor can manage their own bookings
        if ($user->hasRole('Doctor')) {
            $doctor = $user->doctor;
            return $doctor && $booking->doctor_id === $doctor->id;
        }

        // Patient can manage their own bookings
        if ($user->hasRole('Patient')) {
            $patient = $user->patient;
            return $patient && $booking->patient_id === $patient->id;
        }

        return false;
    }
}
