<?php

namespace App\Enums;

final class SubjectsEnum{
    const GENERAL_INQUIRY = 'home.general_inquiry';
    const THERAPIST_REGISTRATION = 'home.therapist_registration';
    const INSTITUTIONAL_PARTNERSHIP = 'home.institutional_partnership';
    const TECHNICAL_SUPPORT = 'home.technical_support';

    public static function all() {
        return [
            self::GENERAL_INQUIRY,
            self::THERAPIST_REGISTRATION,
            self::INSTITUTIONAL_PARTNERSHIP,
            self::TECHNICAL_SUPPORT,
        ];
    }

    public static function translated(): array
    {
        return array_map(fn($key) => __($key), self::all());
    }
}
