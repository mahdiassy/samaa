<?php

namespace App\Enums;

abstract class Permissions extends BasicEnum
{
    // USERS
    const USER_LIST = 'user-list';
    const USER_CREATE = 'user-create';
    const USER_EDIT = 'user-edit';
    const USER_DELETE = 'user-delete';
    const USER_SHOW = 'user-show';

    // DOCTOR
    const DOCTOR_LIST = 'doctor-list';
    const DOCTOR_CREATE = 'doctor-create';
    const DOCTOR_EDIT = 'doctor-edit';
    const DOCTOR_DELETE = 'doctor-delete';
    const DOCTOR_SHOW = 'doctor-show';

    // PATIENT
    const PATIENT_LIST = 'patient-list';
    const PATIENT_CREATE = 'patient-create';
    const PATIENT_EDIT = 'patient-edit';
    const PATIENT_DELETE = 'patient-delete';
    const PATIENT_SHOW = 'patient-show';

    // THERAPY
    const THERAPY_LIST = 'therapy-list';
    const THERAPY_CREATE = 'therapy-create';
    const THERAPY_EDIT = 'therapy-edit';
    const THERAPY_DELETE = 'therapy-delete';
    const THERAPY_SHOW = 'therapy-show';
}
