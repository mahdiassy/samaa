<?php

namespace App\Observers;

use App\Jobs\SendBookingNotification;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;

class BookingObserver
{
    /**
     * Handle the Booking "created" event.
     */
    public function created(Booking $booking): void
    {
        Log::info('New booking created', [
            'booking_id' => $booking->id,
            'patient_id' => $booking->patient_id,
            'status' => $booking->status,
        ]);

        // Dispatch notification job to queue
        SendBookingNotification::dispatch($booking, 'created');
    }

    /**
     * Handle the Booking "updated" event.
     */
    public function updated(Booking $booking): void
    {
        // Log status changes
        if ($booking->isDirty('status')) {
            Log::info('Booking status changed', [
                'booking_id' => $booking->id,
                'patient_id' => $booking->patient_id,
                'old_status' => $booking->getOriginal('status'),
                'new_status' => $booking->status,
            ]);

            // Dispatch notification based on status
            $notificationType = match($booking->status) {
                'approved' => 'approved',
                'rejected' => 'rejected',
                default => 'updated',
            };

            SendBookingNotification::dispatch($booking, $notificationType);
        }
    }

    /**
     * Handle the Booking "deleted" event.
     */
    public function deleted(Booking $booking): void
    {
        Log::info('Booking deleted', [
            'booking_id' => $booking->id,
            'patient_id' => $booking->patient_id,
        ]);
    }
}
