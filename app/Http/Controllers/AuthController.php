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
use Illuminate\Support\Facades\Log;


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
            // Check if user is a doctor and not approved
            $user = Auth::user();
            if ($user->hasRole('Doctor')) {
                $doctor = Doctor::where('user_id', $user->id)->first();
                if ($doctor && !$doctor->is_approved) {
                    Auth::logout();
                    return redirect()->back()->withInput()->with('status', [
                        'type' => 'warning',
                        'title' => __("site.Pending Approval"),
                        'msg' => __("site.Your account is pending admin approval. You will receive an email once your account is approved.")
                    ]);
                }
            }
            
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

            return redirect()->route('dashboard')->with('status', [
                'type' => 'success',
                'title' => __("site.Success"),
                'msg' => __("site.Registration successful! Welcome to our platform.")
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Patient registration failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'data' => $request->except(['password', 'password_confirmation'])
            ]);

            return redirect()->back()->withInput($request->except(['password', 'password_confirmation']))->with('status', [
                'type' => 'error',
                'title' => __("site.Registration Failed"),
                'msg' => __("site.An error occurred during registration. Please check all fields and try again.") . ' ' . $e->getMessage()
            ]);
        }
    }    public function showRegisterDoctor()
    {
        return view("auth.register-doctor");
    }

    public function registerDoctor(\App\Http\Requests\Auth\RegisterDoctorRequest $request)
    {
        try {
            // Register doctor using service (handles user creation, role assignment, file upload)
            $doctor = $this->userRegistrationService->registerDoctor($request->validated());

            // Don't login the doctor, redirect to pending approval page
            return view('auth.doctor-pending-approval')->with('status', [
                'type' => 'success',
                'title' => __("site.Registration Successful"),
                'msg' => __("site.Thank you for registering! Your application is pending admin approval. You will receive an email once your account is approved.")
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Doctor registration failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'data' => $request->except(['password', 'password_confirmation'])
            ]);

            return redirect()->back()->withInput($request->except(['password', 'password_confirmation']))->with('status', [
                'type' => 'error',
                'title' => __("site.Registration Failed"),
                'msg' => __("site.An error occurred during registration. Please check all fields and try again.") . ' ' . $e->getMessage()
            ]);
        }
    }
}
