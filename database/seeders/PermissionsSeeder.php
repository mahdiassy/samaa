<?php

namespace Database\Seeders;

use App\Enums\Permissions;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions (idempotent)
        $permissions = Permissions::getConstants();
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission], ['name' => $permission]);
        }

        // create roles
        $role1 = Role::firstOrCreate(['name' => 'Admin']);
        $role1->givePermissionTo(Permission::all());

        $role2 = Role::firstOrCreate(['name' => 'Doctor']);
        $role2->givePermissionTo([
            Permissions::DOCTOR_LIST,
            Permissions::DOCTOR_SHOW,

            Permissions::PATIENT_LIST,
            Permissions::PATIENT_CREATE,
            Permissions::PATIENT_EDIT,
            Permissions::PATIENT_SHOW,
            Permissions::PATIENT_DELETE,

            Permissions::THERAPY_LIST,
            Permissions::THERAPY_CREATE,
            Permissions::THERAPY_EDIT,
            Permissions::THERAPY_SHOW,
            Permissions::THERAPY_DELETE,

            Permissions::FEEDBACK_CREATE,
            Permissions::FEEDBACK_LIST,
            Permissions::FEEDBACK_SHOW,

            Permissions::BLOG_LIST,
            Permissions::BLOG_SHOW,
        ]);

        $role3 = Role::firstOrCreate(['name' => 'Patient']);
        $role3->givePermissionTo([
            Permissions::DOCTOR_LIST,
            Permissions::DOCTOR_SHOW,

            Permissions::THERAPY_SHOW,
            Permissions::THERAPY_LIST,

            Permissions::FEEDBACK_CREATE,
            Permissions::FEEDBACK_LIST,
            Permissions::FEEDBACK_SHOW,

            Permissions::BLOG_LIST,
            Permissions::BLOG_SHOW,
        ]);

        // create users
        $user = \App\Models\User::firstOrCreate([
            'email' => 'admin@sama3.com',
        ], [
            'name' => 'admin',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole($role1);


        $userdoctor = \App\Models\User::firstOrCreate([
            'email' => 'doctor1@sama3.com',
        ], [
            'name' => 'doctor1',
            'password' => bcrypt('password'),
        ]);
        $userdoctor->assignRole($role2);

        Doctor::firstOrCreate([
            'user_id' => $userdoctor->id,
        ], [
            'first_name' => 'doctor1',
        ]);

        $userpatient = \App\Models\User::firstOrCreate([
            'email' => 'patient1@sama3.com',
        ], [
            'name' => 'patient1',
            'password' => bcrypt('password'),
        ]);
        $userpatient->assignRole($role3);

        Patient::firstOrCreate([
            'user_id' => $userpatient->id,
        ], [
            'first_name' => 'patient1',
            'language_id' => 1,
            'country_id' => 1,
        ]);
    }
}
