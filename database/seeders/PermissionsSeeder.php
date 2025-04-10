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

        // create permissions
        $permissions = Permissions::getConstants();
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // create roles
        $role1 = Role::create(['name' => 'Admin']);
        $role1->givePermissionTo(Permission::all());

        $role2 = Role::create(['name' => 'Doctor']);
        $role2->givePermissionTo([
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
        ]);

        $role3 = Role::create(['name' => 'Patient']);
        $role3->givePermissionTo([
            Permissions::DOCTOR_LIST,
            Permissions::DOCTOR_SHOW,

            Permissions::THERAPY_SHOW,
            Permissions::THERAPY_LIST,

            Permissions::FEEDBACK_CREATE,
            Permissions::FEEDBACK_LIST,
            Permissions::FEEDBACK_SHOW,
        ]);

        // create users
        $user = \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@sama3.com',
        ]);
        $user->assignRole($role1);


        $userdoctor = \App\Models\User::factory()->create([
            'name' => 'doctor1',
            'email' => 'doctor1@sama3.com',
        ]);
        $userdoctor->assignRole($role2);

        Doctor::create([
            'first_name' => 'doctor1',
            'user_id' => $userdoctor->id,
        ]);

        $userpatient = \App\Models\User::factory()->create([
            'name' => 'patient1',
            'email' => 'patient1@sama3.com',
        ]);
        $userpatient->assignRole($role3);

        Patient::create([
            'first_name' => 'patient1',
            'user_id' => $userpatient->id,
            'language_id' => 1,
            'country_id' => 1,
            //'therapeutic_area_id' => 1,
            //'disease_id' => 1,
            //'psychological_id' => 1,
        ]);
    }
}
