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
use App\Models\Psychological;
use App\Models\Symptom;
use App\Models\Therapeutic_area;
use App\Models\User;
use App\Services\User\UserRegistrationService;
use App\Services\Patient\PatientDiseaseService;
use App\Services\Response\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DateTime;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{
    protected $dir = "auth.";

    public function __construct(
        protected UserRegistrationService $userRegistrationService,
        protected PatientDiseaseService $patientDiseaseService,
        protected ResponseService $responseService
    ) {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view($this->dir . "login");
    }

    public function login(\App\Http\Requests\Auth\LoginRequest $request)
    {
        // Request is automatically validated by LoginRequest
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

    public function registerPatient(\App\Http\Requests\Auth\RegisterPatientRequest $request)
    {
        try {
            // Register patient using service (handles user creation, role assignment, file upload)
            $patient = $this->userRegistrationService->registerPatient($request->validated());

            // Sync diseases using service (handles all 8 disease types)
            $this->patientDiseaseService->syncDiseases($patient, $request->validated());

            // Login the newly registered user
            Auth::guard()->login($patient->user);

            return $this->responseService->success(
                __("site.Successfully Logged-in"),
                'dashboard'
            );
        } catch (\Exception $e) {
            Session::flash('error', __("site.Error") . ': ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }    public function showRegisterDoctor()
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

    public function registerDoctor(\App\Http\Requests\Auth\RegisterDoctorRequest $request)
    {
        try {
            // Register doctor using service (handles user creation, role assignment, file upload)
            $doctor = $this->userRegistrationService->registerDoctor($request->validated());

            // Login the newly registered user
            Auth::guard()->login($doctor->user);

            return $this->responseService->success(
                __("site.Successfully Logged-in"),
                'dashboard'
            );
        } catch (\Exception $e) {
            Session::flash('error', __("site.Error") . ': ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
}
