<?php

namespace App\Jobs;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendBookingNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Booking $booking,
        public string $notificationType
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Load relationships
        $this->booking->load(['patient.user', 'availability.doctor']);

        Log::info("Booking notification sent", [
            'booking_id' => $this->booking->id,
            'type' => $this->notificationType,
            'patient_id' => $this->booking->patient_id,
            'status' => $this->booking->status,
        ]);

        // TODO: Implement actual notification logic here
        // Examples:
        // - Send email notification
        // - Send SMS notification
        // - Push notification to mobile app
        // - Slack/Discord webhook notification

        /*
        switch ($this->notificationType) {
            case 'created':
                // Notify doctor: new booking request
                break;
            case 'approved':
                // Notify patient: booking approved
                break;
            case 'rejected':
                // Notify patient: booking rejected
                break;
        }
        */
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("Booking notification failed", [
            'booking_id' => $this->booking->id,
            'type' => $this->notificationType,
            'error' => $exception->getMessage(),
        ]);
    }
}
