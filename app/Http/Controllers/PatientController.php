<?php

namespace App\Http\Controllers;

use App\Enums\Permissions;
use App\Models\Addiction;
use App\Models\Consultation;
use App\Models\Country;
use App\Models\Disease;
use App\Models\Incident;
use App\Models\Language;
use App\Models\Nervous;
use App\Models\Patient;
use App\Models\PatientDisease;
use App\Models\Psychological;
use App\Models\Symptom;
use App\Models\Therapeutic_area;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Patient\StorePatientRequest;
use App\Http\Requests\Patient\UpdatePatientRequest;
use App\Services\File\FileUploadService;

class PatientController extends Controller
{
    protected $dir = "patient.";
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
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
        $therapeutic_areas = Therapeutic_area::all();
        $diseases = Disease::all();
        $nervouses = Nervous::all();
        $symptoms = Symptom::all();
        $addictions = Addiction::all();
        $incidents = Incident::all();
        $consultations = Consultation::all();
        $psychological_diseases = Psychological::all();
        return view($this->dir . "create", compact('countries', 'languages', 'therapeutic_areas', 'diseases', 'psychological_diseases', 'nervouses', 'symptoms', 'addictions', 'incidents', 'consultations'));
    }

    public function store(StorePatientRequest $request)
    {
        try {
            $patient = new Patient;
            $patient->first_name = $request->first_name;
            $patient->last_name = $request->surname;
            $patient->birthday = $request->birthday;
            $patient->phone = $request->phone;
            $patient->address = $request->address;
            $patient->country_id = $request->country_id;
            $patient->language_id = $request->language_id;
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

            // Upload profile image securely if provided
            if ($request->hasFile('image')) {
                $patient->image = $this->fileUploadService->uploadImage(
                    $request->file('image'),
                    'patients'
                );
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

            return redirect()->route('patient.index')->with('status', [
                'type' => 'success',
                'title' =>  __("site.Success"),
                'msg' => __("site.Patient created successfully")
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                Session::flash('error', __("site.This email is already registered."));
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
        $therapeutic_areas = Therapeutic_area::all();
        $diseases = Disease::all();
        $nervouses = Nervous::all();
        $symptoms = Symptom::all();
        $addictions = Addiction::all();
        $incidents = Incident::all();
        $consultations = Consultation::all();
        $psychological_diseases = Psychological::all();
        $patientDisease = PatientDisease::where('patient_id', $patient->id)
            ->where('diseasable_type', Therapeutic_area::class)
            ->first();
        $medications = $patientDisease ? $patientDisease->medications : null;
        return view($this->dir . "edit", compact('patient', 'countries', 'languages', 'therapeutic_areas', 'diseases', 'psychological_diseases', 'nervouses', 'symptoms', 'addictions', 'incidents', 'consultations', 'medications'));
    }

    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        try {
            $patient->first_name = $request->first_name;
            $patient->last_name = $request->surname;
            $patient->birthday = $request->birthday;
            $patient->phone = $request->phone;
            $patient->address = $request->address;
            $patient->country_id = $request->country_id;
            $patient->language_id = $request->language_id;
            $patient->gender = $request->gender;
            $patient->open_description = $request->open_description;
            $patient->twitter = null;
            $patient->facebook = null;
            $patient->instagram = null;

            $user = User::find($patient->user_id);
            $user->name = $request->first_name;
            $user->email = $request->email;
            
            // Update password only if provided
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            
            $user->save();
            $user->syncRoles('Patient');

            // Upload new profile image if provided
            if ($request->hasFile('image')) {
                $oldImagePath = $patient->image;
                $patient->image = $this->fileUploadService->uploadImage(
                    $request->file('image'),
                    'patients',
                    $oldImagePath
                );
            }

            $patient->save();

            PatientDisease::where('patient_id', $patient->id)->delete();

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

            return redirect()->route('patient.index')->with('status', [
                'type' => 'success',
                'title' =>  __("site.Success"),
                'msg' => __("site.Patient updated successfully")
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                Session::flash('error',  __("site.Error"));
            } else {
                throw $e;
            }
        }
        return redirect()->back();
    }

    public function editProfile(Request $request, Patient $patient)
    {
        $languages = Language::all();
        $countries = Country::all();
        $therapeutic_areas = Therapeutic_area::all();
        $diseases = Disease::all();
        $nervouses = Nervous::all();
        $symptoms = Symptom::all();
        $addictions = Addiction::all();
        $incidents = Incident::all();
        $consultations = Consultation::all();
        $psychological_diseases = Psychological::all();
        $patientDisease = PatientDisease::where('patient_id', $patient->id)
            ->where('diseasable_type', Therapeutic_area::class)
            ->first();
        $medications = $patientDisease ? $patientDisease->medications : null;
        return view($this->dir . "profile", compact('patient', 'countries', 'languages', 'therapeutic_areas', 'diseases', 'psychological_diseases', 'nervouses', 'symptoms', 'addictions', 'incidents', 'consultations', 'medications'));
    }

    public function updateProfile(Request $request, Patient $patient)
    {
        try {
            if (User::where('email', $request->email)->where('id', '!=', $patient->user_id)->exists()) {
                return redirect()->back()->with('status', [
                    'type' => 'error',
                    'title' =>  __("site.Success"),
                    'msg' => __("site.The email address is already in use by another user"),
                ]);
            } else {
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

                PatientDisease::where('patient_id', $patient->id)->delete();

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

                return redirect()->back()->with('status', [
                    'type' => 'success',
                    'title' =>  __("site.Success"),
                    'msg' => __("site.Patient Profile updated successfully")
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

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patient.index')->with('status', [
            'type' => 'success',
            'title' =>  __("site.Success"),
            'msg' => __("site.Patient deleted successfully")
        ]);
    }

    public function show(Patient $patient)
    {
        $psychologicals = $patient->psychologicals()->get();
        $nervouses = $patient->nervouses()->get();
        $therapeutic_areas = $patient->therapeutic_areas()->get();
        $symptomes = $patient->symptomes()->get();
        $addictiones = $patient->addictiones()->get();
        $diseases = $patient->diseases()->get();
        $incidents = $patient->incidents()->get();
        $consultationes = $patient->consultationes()->get();
        $patientDisease = PatientDisease::where('patient_id', $patient->id)
            ->where('diseasable_type', Therapeutic_area::class)
            ->first();
        $medications = $patientDisease ? $patientDisease->medications : null;
        return view($this->dir . "show", compact('patient', 'diseases', 'addictiones', 'consultationes', 'incidents', 'psychologicals', 'symptomes', 'therapeutic_areas', 'nervouses', 'medications'));
    }
}
