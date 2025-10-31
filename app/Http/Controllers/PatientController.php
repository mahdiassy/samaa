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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Patient\StorePatientRequest;
use App\Http\Requests\Patient\UpdatePatientRequest;
use App\Services\File\FileUploadService;
use App\Services\User\UserRegistrationService;
use App\Services\Patient\PatientDiseaseService;
use App\Services\Response\ResponseService;

class PatientController extends Controller
{
    public function __construct(
        protected FileUploadService $fileUploadService,
        protected UserRegistrationService $userRegistrationService,
        protected PatientDiseaseService $patientDiseaseService,
        protected ResponseService $responseService
    ) {
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
            $patients = Patient::with(['user', 'country', 'language'])->paginate(9);
        } elseif (auth()->user()->hasRole('Doctor')) {
            // ?????
            $patients = Patient::with(['user', 'country', 'language'])->paginate(9);
        }

        return view("patient.index", compact('patients'));
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
        return view("patient.create", compact('countries', 'languages', 'therapeutic_areas', 'diseases', 'psychological_diseases', 'nervouses', 'symptoms', 'addictions', 'incidents', 'consultations'));
    }

    public function store(StorePatientRequest $request)
    {
        try {
            // Register patient using service
            $patient = $this->userRegistrationService->registerPatient($request->validated());

            // Sync diseases using service
            $this->patientDiseaseService->syncDiseases($patient, $request->validated());

            return $this->responseService->success(
                __("site.Patient created successfully"),
                'patient.index'
            );
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('status', [
                'type' => 'error',
                'title' => __("site.Error"),
                'msg' => __("site.Error") . ': ' . $e->getMessage()
            ]);
        }
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
        return view("patient.edit", compact('patient', 'countries', 'languages', 'therapeutic_areas', 'diseases', 'psychological_diseases', 'nervouses', 'symptoms', 'addictions', 'incidents', 'consultations', 'medications'));
    }

    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        try {
            // Update patient using service
            $patient = $this->userRegistrationService->updatePatient($patient, $request->validated());

            // Sync diseases using service
            $this->patientDiseaseService->syncDiseases($patient, $request->validated());

            return $this->responseService->success(
                __("site.Patient updated successfully"),
                'patient.index'
            );
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('status', [
                'type' => 'error',
                'title' => __("site.Error"),
                'msg' => __("site.Error") . ': ' . $e->getMessage()
            ]);
        }
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
        return view("patient.profile", compact('patient', 'countries', 'languages', 'therapeutic_areas', 'diseases', 'psychological_diseases', 'nervouses', 'symptoms', 'addictions', 'incidents', 'consultations', 'medications'));
    }

    public function updateProfile(Request $request, Patient $patient)
    {
        try {
            // Prepare data from request (convert old field names for backward compatibility)
            $data = $request->all();
            $data['surname'] = $data['last_name'] ?? $data['surname'] ?? null;
            $data['country_id'] = $data['country'] ?? $data['country_id'] ?? null;
            $data['language_id'] = $data['language'] ?? $data['language_id'] ?? null;

            // Update patient using service
            $patient = $this->userRegistrationService->updatePatient($patient, $data);

            // Sync diseases using service
            $this->patientDiseaseService->syncDiseases($patient, $data);

            return $this->responseService->successBack(__("site.Patient Profile updated successfully"));
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('status', [
                'type' => 'error',
                'title' => __("site.Error"),
                'msg' => __("site.Error") . ': ' . $e->getMessage()
            ]);
        }
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
        return view("patient.show", compact('patient', 'diseases', 'addictiones', 'consultationes', 'incidents', 'psychologicals', 'symptomes', 'therapeutic_areas', 'nervouses', 'medications'));
    }
}
