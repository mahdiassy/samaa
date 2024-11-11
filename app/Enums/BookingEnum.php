<?php

namespace App\Enums;

final class BookingEnum{
    const PENDING = "Pending";
    const APPROVED = "Approved";
    const DONE = "Done";
    const DOCTOR_CANCEL = "Canceled";
    const PATIENT_CANCEL = "Canceled By Patient";

    public static function all() {
        return [
            self::PENDING,
            self::APPROVED,
            self::DOCTOR_CANCEL,
            self::PATIENT_CANCEL,
        ];
    }

    public static function doctorActions() {
        return [
            self::APPROVED,
            self::DOCTOR_CANCEL,
        ];
    }
}
