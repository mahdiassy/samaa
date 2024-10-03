<?php

namespace App\Enums;

final class BookingEnum{
    const PENDING = "Pending";
    const APPROVED = "Approved";
    const DONE = "Done";
    const DOCTOR_CANCEL = "Canceled By Doctor";
    const PATIENT_CANCEL = "Canceled By Patient";
    
    public static function all() {
        return [
            self::PENDING,
            self::APPROVED,
            self::DONE,
            self::DOCTOR_CANCEL,
            self::PATIENT_CANCEL,
        ];
    }
}
