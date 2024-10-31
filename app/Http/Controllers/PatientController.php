<?php

namespace App\Http\Controllers;

use App\Enums\Permissions;
use App\Models\Country;
use App\Models\Language;
use App\Models\Patient;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PatientController extends Controller
{
    protected $dir = "patient.";

    public function __construct()
    {
        $this->middleware('permission:' . Permissions::PATIENT_LIST)->only(['index']);
        $this->middleware('permission:' . Permissions::PATIENT_CREATE)->only(['create', 'store']);
        $this->middleware('permission:' . Permissions::PATIENT_SHOW)->only(['show']);
        $this->middleware('permission:' . Permissions::PATIENT_EDIT)->only(['edit', 'update']);
        $this->middleware('permission:' . Permissions::PATIENT_DELETE)->only(['destroy']);
    }

    public function index()
    {
        $therapies = collect();
        if (auth()->user()->hasRole('Admin')) {
            $patients = Patient::paginate(9);
        } elseif (auth()->user()->hasRole('Doctor')) {
            // ?????
            $patients = Patient::paginate(9);
        }

        return view($this->dir . "index", compact('patients'));
    }

    public function create()
    {
        $languages = Language::all();
        $countries = Country::all();
        return view($this->dir . "create", compact('countries', 'languages'));
    }

    public function store(Request $request)
    {
        try {
            $patient = new Patient;
            $patient->first_name = $request->first_name;
            $patient->last_name = $request->last_name;
            $patient->phone = $request->phone;
            $patient->address = $request->address;
            $patient->birthday = $request->birthday;
            $patient->country_id = $request->country;
            $patient->language_id = $request->language;
            $patient->gender = $request->gender;
            $patient->blood_type = $request->blood_type;
            $patient->weight = $request->weight;
            $patient->height = $request->height;
            $patient->is_smoker = $request->smoker;
            $patient->twitter = null;
            $patient->facebook = null;
            $patient->instagram = null;

            $user = new User;
            $user->name = $request->first_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $user->assignRole('Patient');

            $patient->user_id = $user->id;

            if ($request->has('image')) {
                $image = $request->file('image');
                $patient->image = $this->storeFile($image, 'Patient image');
            } else {
                $patient->image = '/avatar1.png';
            }

            $patient->save();

            return redirect()->route('patient.index')->with('status', [
                'type' => 'success',
                'msg' => 'Patient created successfully'
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                Session::flash('error', 'This email is already registered.');
            } else {
                throw $e;
            }
        }

        return redirect()->back();
    }

    public function edit(Request $request, Patient $patient)
    {
        $languages = Language::all();
        $countries = Country::all();
        return view($this->dir . "edit", compact('patient', 'countries', 'languages'));
    }

    public function update(Request $request, Patient $patient)
    {
        /*$dateString = $request->birthday;
        $date = DateTime::createFromFormat('F, j, Y', $dateString);
        $birthday = $date->format('Y-m-d');*/

        $patient->first_name = $request->first_name;
        $patient->last_name = $request->last_name;
        $patient->phone = $request->phone;
        $patient->address = $request->address;
        $patient->birthday = $request->birthday;
        $patient->country_id = $request->country;
        $patient->language_id = $request->language;
        $patient->gender = $request->gender;
        $patient->blood_type = $request->blood_type;
        $patient->weight = $request->weight;
        $patient->height = $request->height;
        $patient->is_smoker = $request->smoker;
        $patient->twitter = null;
        $patient->facebook = null;
        $patient->instagram = null;

        $user = User::find($patient->user_id);
        $user->name = $request->first_name;
        $user->email = $request->email;
        $user->save();
        $user->syncRoles('Patient');

        if ($request->has('image')) {
            $image = $request->file('image');
            $patient->image = $this->storeFile($image, 'Patient image');
        }

        $patient->save();

        return redirect()->route('patient.index')->with('status', [
            'type' => 'success',
            'msg' => 'Patient updated successfully'
        ]);
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patient.index')->with('status', [
            'type' => 'success',
            'msg' => 'Patient deleted successfully'
        ]);
    }

    public function show(Patient $patient)
    {
        return view($this->dir . "show", compact('patient'));
    }
}
