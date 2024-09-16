<?php

namespace App\Http\Controllers;

use App\Enums\Permissions;
use App\Models\Doctor;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DoctorController extends Controller
{
    protected $dir = "doctor.";

    public function __construct()
    {
        $this->middleware('permission:' . Permissions::DOCTOR_LIST)->only(['index']);
        $this->middleware('permission:' . Permissions::DOCTOR_CREATE)->only(['create', 'store']);
        $this->middleware('permission:' . Permissions::DOCTOR_SHOW)->only(['show']);
        $this->middleware('permission:' . Permissions::DOCTOR_EDIT)->only(['edit', 'update']);
        $this->middleware('permission:' . Permissions::DOCTOR_DELETE)->only(['destroy']);
    }

    public function index()
    {
        $doctors = Doctor::paginate(9);
        return view($this->dir . "index", compact('doctors'));
    }

    public function create()
    {
        $roles = Role::all();
        return view($this->dir . "create", compact('roles'));
    }

    public function store(Request $request)
    {
        $dateString = $request->birthday;
        $date = DateTime::createFromFormat('F, j, Y', $dateString);
        $birthday = $date->format('Y-m-d');

        $doctor = new Doctor;
        $doctor->first_name = $request->first_name;
        $doctor->last_name = $request->last_name;
        $doctor->phone = $request->phone;
        $doctor->address = $request->address;
        $doctor->birthday = $birthday;
        $doctor->twitter = $request->twitter;
        $doctor->facebook = $request->facebook;
        $doctor->instagram = $request->instagram;

        $user = new User;
        $user->name = $request->first_name;
        $user->email= $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $user->assignRole($request->role);

        $doctor->user_id = $user->id;

        if ($request->has('image')) {
            $image = $request->file('image');
            $doctor->image = $this->storeFile($image, 'Doctor image');
        }else{
            $doctor->image = '/avatar1.png';
        }

        $doctor->save();

        return redirect()->route('doctor.index')->with('status', [
            'type' => 'success',
            'msg' => 'Doctor created successfully'
        ]);
    }

    public function edit(Request $request, Doctor $doctor)
    {
        $roles = Role::all();
        return view($this->dir . "edit", compact('doctor','roles'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $dateString = $request->birthday;
        $date = DateTime::createFromFormat('F, j, Y', $dateString);
        $birthday = $date->format('Y-m-d');

        $doctor->first_name = $request->first_name;
        $doctor->last_name = $request->last_name;
        $doctor->phone = $request->phone;
        $doctor->address = $request->address;
        $doctor->birthday = $birthday;
        $doctor->twitter = $request->twitter;
        $doctor->facebook = $request->facebook;
        $doctor->instagram = $request->instagram;

        $user = User::find($doctor->user_id);
        $user->name = $request->first_name;
        $user->email= $request->email;
        $user->save();
        $user->syncRoles($request->role);

        if ($request->has('image')) {
            $image = $request->file('image');
            $doctor->image = $this->storeFile($image, 'Doctor image');
        }else{
            $doctor->image = '/avatar1.png';
        }

        $doctor->save();

        return redirect()->route('doctor.index')->with('status', [
            'type' => 'success',
            'msg' => 'Doctor updated successfully'
        ]);
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctor.index')->with('status', [
            'type' => 'success',
            'msg' => 'Doctor deleted successfully'
        ]);
    }

    public function show(Doctor $doctor)
    {
        return view($this->dir . "show", compact('doctor'));
    }
}
