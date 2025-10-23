<?php

namespace App\Http\Controllers;

use App\Models\Addiction;
use App\Models\Consultation;
use App\Models\Country;
use App\Models\Disease;
use App\Models\Doctor;
use App\Models\Incident;
use App\Models\Language;
use App\Models\Nervous;
use App\Models\Patient;
use App\Models\PatientDisease;
use App\Models\Psychological;
use App\Models\Symptom;
use App\Models\Therapeutic_area;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DateTime;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{
    protected $dir = "auth.";

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view($this->dir . "login");
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()
                ->route('dashboard')
                ->with('status', [
                    'type' => 'success',
                    'title' => __("site.Success"),
                    'msg' => __("site.Successfully Logged-in"),
                ]);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            Session::flash('error', __("site.The email address is incorrect"));
        } elseif (!Hash::check($request->password, $user->password)) {
            Session::flash('error', __("site.Password is incorrect"));
        } else {
            Session::flash('error', __("site.Login failed. Please try again."));
        }

        return redirect()->back()->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function showRegisterForm()
    {
        return view($this->dir . "register");
    }

    public function showRegisterPatient()
    {
        $countries = Country::all();
        $languages = Language::all();
        $therapeutic_areas = Therapeutic_area::all();
        $diseases = Disease::all();
        $nervouses = Nervous::all();
        $symptoms = Symptom::all();
        $addictions = Addiction::all();
        $incidents = Incident::all();
        $consultations = Consultation::all();
        $psychological_diseases = Psychological::all();
        return view($this->dir . "register-patient", compact('countries', 'languages', 'therapeutic_areas', 'diseases', 'psychological_diseases', 'nervouses', 'symptoms', 'addictions', 'incidents', 'consultations'));
    }

    public function registerPatient(Request $request)
    {
        try {
            if (User::where('email', $request->email)->exists()) {
                Session::flash('error', __("site.The email address is already in use by another user"));
            } else {

                $patient = new Patient;
                $patient->first_name = $request->first_name;
                $patient->last_name = $request->last_name;
                $patient->birthday = $request->birthday;
                $patient->phone = $request->phone;
                $patient->address = null;
                $patient->country_id = $request->country;
                $patient->language_id = $request->language;
                $patient->gender = $request->gender;
                $patient->open_description = $request->open_description;
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
                }

                $patient->save();

                $Ttherapeutic_area = Therapeutic_area::find($request->therapeutic_areas);
                $medications = $request->therapeutic_areas == '2' ? $request->medications : null;
                PatientDisease::create([
                    'patient_id' => $patient->id,
                    'diseasable_id' => $Ttherapeutic_area->id,
                    'diseasable_type' => get_class($Ttherapeutic_area),
                    'medications' => $medications,
                ]);

                $addiction = Addiction::find($request->addiction);
                PatientDisease::create([
                    'patient_id' => $patient->id,
                    'diseasable_id' => $addiction->id,
                    'diseasable_type' => get_class($addiction),
                    'medications' => null,
                ]);

                $consultation = Consultation::find($request->consultation);
                PatientDisease::create([
                    'patient_id' => $patient->id,
                    'diseasable_id' => $consultation->id,
                    'diseasable_type' => get_class($consultation),
                    'medications' => null,
                ]);

                if ($request->diseases) {
                    foreach ($request->diseases as $disease) {

                        $Disease = Disease::find($disease);
                        PatientDisease::create([
                            'patient_id' => $patient->id,
                            'diseasable_id' => $Disease->id,
                            'diseasable_type' => get_class($Disease),
                            'medications' => null,
                        ]);
                    }
                }

                if ($request->nervouses) {
                    foreach ($request->nervouses as $nervous) {

                        $Nervous = Nervous::find($nervous);
                        PatientDisease::create([
                            'patient_id' => $patient->id,
                            'diseasable_id' => $Nervous->id,
                            'diseasable_type' => get_class($Nervous),
                            'medications' => null,
                        ]);
                    }
                }

                if ($request->symptoms) {
                    foreach ($request->symptoms as $symptom) {

                        $Symptom = Symptom::find($symptom);
                        PatientDisease::create([
                            'patient_id' => $patient->id,
                            'diseasable_id' => $Symptom->id,
                            'diseasable_type' => get_class($Symptom),
                            'medications' => null,
                        ]);
                    }
                }

                if ($request->incidents) {
                    foreach ($request->incidents as $incident) {

                        $Incident = Incident::find($incident);
                        PatientDisease::create([
                            'patient_id' => $patient->id,
                            'diseasable_id' => $Incident->id,
                            'diseasable_type' => get_class($Incident),
                            'medications' => null,
                        ]);
                    }
                }

                if ($request->psychological_diseases) {
                    foreach ($request->psychological_diseases as $psychological_disease) {

                        $Psychological = Psychological::find($psychological_disease);
                        if ($Psychological) {

                            PatientDisease::create([
                                'patient_id' => $patient->id,
                                'diseasable_id' => $Psychological->id,
                                'diseasable_type' => get_class($Psychological),
                                'medications' => null,
                            ]);
                        }
                    }
                }

                Auth::guard()->login($user);

                return redirect()
                    ->intended(route('dashboard'))
                    ->with('status', [
                        'type' => 'success',
                        'title' =>  __("site.Success"),
                        'msg' => __("site.Successfully Logged-in"),
                    ]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                Session::flash('error',  __("site.Error"));
            } else {
                throw $e;
            }
        }

        return redirect()->back();
    }

    public function showRegisterDoctor()
    {
        $countries = Country::all();
        $languages = Language::all();
        $therapeutic_areas = Therapeutic_area::all();
        $diseases = Disease::all();
        $nervouses = Nervous::all();
        $symptoms = Symptom::all();
        $addictions = Addiction::all();
        $incidents = Incident::all();
        $consultations = Consultation::all();
        $psychological_diseases = Psychological::all();
        return view($this->dir . "register-doctor", compact('countries', 'languages', 'therapeutic_areas', 'diseases', 'psychological_diseases', 'nervouses', 'symptoms', 'addictions', 'incidents', 'consultations'));
    }

    public function registerDoctor(Request $request)
    {
        try {
            if (User::where('email', $request->email)->exists()) {
                Session::flash('error', __("site.The email address is already in use by another user"));
            } else {

                $doctor = new Doctor;
                $doctor->first_name = $request->first_name;
                $doctor->last_name = $request->last_name;
                $doctor->birthday = $request->birthday;
                $doctor->phone = $request->phone;
                $doctor->address = $request->address;
                $doctor->specialization = $request->specialization;
                $doctor->twitter = null;
                $doctor->facebook = null;
                $doctor->instagram = null;

                $user = new User;
                $user->name = $request->first_name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->save();
                $user->assignRole('Doctor');

                $doctor->user_id = $user->id;

                if ($request->has('image')) {
                    $image = $request->file('image');
                    $doctor->image = $this->storeFile($image, 'Doctor image');
                }

                $doctor->save();

                Auth::guard()->login($user);

                return redirect()
                    ->intended(route('dashboard'))
                    ->with('status', [
                        'type' => 'success',
                        'title' =>  __("site.Success"),
                        'msg' => __("site.Successfully Logged-in"),
                    ]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                Session::flash('error',  __("site.Error"));
            } else {
                throw $e;
            }
        }

        return redirect()->back();
    }
}
