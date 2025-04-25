<?php

namespace App\Enums;

final class BookingEnum{
    const PENDING = "site.Pending";
    const APPROVED = "site.Approved";
    const DONE = "site.Done";
    const DOCTOR_CANCEL = "site.Canceled";
    const PATIENT_CANCEL = "site.Canceled By Patient";

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

    public static function translated(): array
    {
        return array_map(fn($key) => __($key), self::all());
    }
}
