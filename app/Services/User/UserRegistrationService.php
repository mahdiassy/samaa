<?php

namespace App\Services\User;

use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Services\File\FileUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Exception;

class UserRegistrationService
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Register a new patient with user account.
     *
     * @param array $data Patient registration data
     * @return Patient
     * @throws Exception
     */
    public function registerPatient(array $data): Patient
    {
        DB::beginTransaction();

        try {
            // Create user account
            $user = new User();
            $user->name = $data['first_name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->save();

            // Assign patient role
            $user->assignRole('Patient');

            // Create patient profile
            $patient = new Patient();
            $patient->user_id = $user->id;
            $patient->first_name = $data['first_name'];
            $patient->last_name = $data['surname'] ?? $data['last_name'] ?? null;
            $patient->phone = $data['phone'];
            $patient->birthday = $data['birthday'] ?? null;
            $patient->address = $data['address'] ?? null;
            $patient->country_id = $data['country_id'] ?? null;
            $patient->language_id = $data['language_id'] ?? null;
            $patient->gender = $data['gender'];
            $patient->open_description = $data['open_description'] ?? null;
            
            // Social media (optional)
            $patient->twitter = $data['twitter'] ?? null;
            $patient->facebook = $data['facebook'] ?? null;
            $patient->instagram = $data['instagram'] ?? null;

            // Handle profile image upload
            if (!empty($data['image']) && $data['image'] instanceof UploadedFile) {
                $patient->image = $this->fileUploadService->uploadImage(
                    $data['image'],
                    'patients'
                );
            }

            $patient->save();

            DB::commit();

            return $patient;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Register a new doctor with user account.
     *
     * @param array $data Doctor registration data
     * @return Doctor
     * @throws Exception
     */
    public function registerDoctor(array $data): Doctor
    {
        DB::beginTransaction();

        try {
            // Create user account
            $user = new User();
            $user->name = $data['first_name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->save();

            // Assign doctor role
            $user->assignRole('Doctor');

            // Create doctor profile
            $doctor = new Doctor();
            $doctor->user_id = $user->id;
            $doctor->first_name = $data['first_name'];
            $doctor->last_name = $data['surname'] ?? $data['last_name'] ?? null;
            $doctor->phone = $data['phone'];
            $doctor->specialization = $data['specialization'];
            $doctor->address = $data['address'] ?? null;
            $doctor->birthday = $data['birthday'] ?? null;
            
            // Social media (optional)
            $doctor->twitter = $data['twitter'] ?? null;
            $doctor->facebook = $data['facebook'] ?? null;
            $doctor->instagram = $data['instagram'] ?? null;

            // Handle profile image upload
            if (!empty($data['image']) && $data['image'] instanceof UploadedFile) {
                $doctor->image = $this->fileUploadService->uploadImage(
                    $data['image'],
                    'doctors'
                );
            }

            $doctor->save();

            DB::commit();

            return $doctor;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update patient profile (without creating new user).
     *
     * @param Patient $patient
     * @param array $data
     * @return Patient
     * @throws Exception
     */
    public function updatePatient(Patient $patient, array $data): Patient
    {
        DB::beginTransaction();

        try {
            // Update user account
            $user = $patient->user;
            $user->name = $data['first_name'];
            $user->email = $data['email'];
            
            // Update password if provided
            if (!empty($data['password'])) {
                $user->password = Hash::make($data['password']);
            }
            
            $user->save();
            $user->syncRoles('Patient');

            // Update patient profile
            $patient->first_name = $data['first_name'];
            $patient->last_name = $data['surname'] ?? $data['last_name'] ?? null;
            $patient->phone = $data['phone'];
            $patient->birthday = $data['birthday'] ?? null;
            $patient->address = $data['address'] ?? null;
            $patient->country_id = $data['country_id'] ?? null;
            $patient->language_id = $data['language_id'] ?? null;
            $patient->gender = $data['gender'];
            $patient->open_description = $data['open_description'] ?? null;
            
            $patient->twitter = $data['twitter'] ?? null;
            $patient->facebook = $data['facebook'] ?? null;
            $patient->instagram = $data['instagram'] ?? null;

            // Handle profile image upload
            if (!empty($data['image']) && $data['image'] instanceof UploadedFile) {
                $oldImagePath = $patient->image;
                $patient->image = $this->fileUploadService->uploadImage(
                    $data['image'],
                    'patients',
                    $oldImagePath
                );
            }

            $patient->save();

            DB::commit();

            return $patient;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update doctor profile (without creating new user).
     *
     * @param Doctor $doctor
     * @param array $data
     * @return Doctor
     * @throws Exception
     */
    public function updateDoctor(Doctor $doctor, array $data): Doctor
    {
        DB::beginTransaction();

        try {
            // Update user account
            $user = $doctor->user;
            $user->name = $data['first_name'];
            $user->email = $data['email'];
            
            // Update password if provided
            if (!empty($data['password'])) {
                $user->password = Hash::make($data['password']);
            }
            
            $user->save();
            $user->syncRoles('Doctor');

            // Update doctor profile
            $doctor->first_name = $data['first_name'];
            $doctor->last_name = $data['surname'] ?? $data['last_name'] ?? null;
            $doctor->phone = $data['phone'];
            $doctor->specialization = $data['specialization'];
            $doctor->address = $data['address'] ?? null;
            $doctor->birthday = $data['birthday'] ?? null;
            
            $doctor->twitter = $data['twitter'] ?? null;
            $doctor->facebook = $data['facebook'] ?? null;
            $doctor->instagram = $data['instagram'] ?? null;

            // Handle profile image upload
            if (!empty($data['image']) && $data['image'] instanceof UploadedFile) {
                $oldImagePath = $doctor->image;
                $doctor->image = $this->fileUploadService->uploadImage(
                    $data['image'],
                    'doctors',
                    $oldImagePath
                );
            }

            $doctor->save();

            DB::commit();

            return $doctor;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
