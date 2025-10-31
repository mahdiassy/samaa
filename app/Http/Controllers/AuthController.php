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


class AuthController extends Controller
{
    public function __construct(
        protected UserRegistrationService $userRegistrationService,
        protected PatientDiseaseService $patientDiseaseService,
        protected ResponseService $responseService
    ) {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view("auth.login");
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
            return redirect()->back()->withInput()->with('status', [
                'type' => 'error',
                'title' => __("site.Error"),
                'msg' => __("site.The email address is incorrect")
            ]);
        } elseif (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->withInput()->with('status', [
                'type' => 'error',
                'title' => __("site.Error"),
                'msg' => __("site.Password is incorrect")
            ]);
        }

        return redirect()->back()->withInput()->with('status', [
            'type' => 'error',
            'title' => __("site.Error"),
            'msg' => __("site.Login failed. Please try again.")
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function showRegisterForm()
    {
        return view("auth.register");
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
        return view("auth.register-patient", compact('countries', 'languages', 'therapeutic_areas', 'diseases', 'psychological_diseases', 'nervouses', 'symptoms', 'addictions', 'incidents', 'consultations'));
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
            return redirect()->back()->withInput()->with('status', [
                'type' => 'error',
                'title' => __("site.Error"),
                'msg' => __("site.Error") . ': ' . $e->getMessage()
            ]);
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
        return view("auth.register-doctor", compact('countries', 'languages', 'therapeutic_areas', 'diseases', 'psychological_diseases', 'nervouses', 'symptoms', 'addictions', 'incidents', 'consultations'));
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
            return redirect()->back()->withInput()->with('status', [
                'type' => 'error',
                'title' => __("site.Error"),
                'msg' => __("site.Error") . ': ' . $e->getMessage()
            ]);
        }
    }
}
