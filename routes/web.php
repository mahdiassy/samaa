<?php

use App\Http\Controllers\TherapyController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {

    // ========================================
    // PUBLIC ROUTES (Guest)
    // ========================================
    Route::get('/', [HomeController::class, 'home'])->name('home');
    Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('about-us');
    Route::get('/how-it-work', [HomeController::class, 'howItWork'])->name('how-it-work');
    Route::get('/therapists', [HomeController::class, 'therapists'])->name('therapists');
    
    // Contact Us
    Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('contact-us');
    Route::post('/store-contact-us', [HomeController::class, 'storeContactUsForm'])
        ->name('contactUs.store')
        ->middleware('throttle:contact');

    // Static Pages
    Route::get('/listenToMusic', fn() => view('frontend/listenToMusic'));
    Route::get('/listener-statistics', fn() => view('frontend/listener-statistics'));
    Route::get('/doctor-search', [DoctorController::class, 'search'])->name('doctor.search');

    // Public Blog
    Route::get('blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('blog/{blog}', [BlogController::class, 'show'])->name('blog.show');

    // Debug route - check permissions
    Route::get('debug-permissions', function () {
        $user = auth()->user();
        if (!$user) {
            return 'Not logged in';
        }
        return [
            'user' => $user->name,
            'email' => $user->email,
            'id' => $user->id,
            'roles' => $user->getRoleNames(),
            'permissions_count' => $user->getAllPermissions()->count(),
            'has_doctor_list' => $user->hasPermissionTo('doctor-list'),
            'has_doctor_create' => $user->hasPermissionTo('doctor-create'),
        ];
    })->middleware('auth');

    // Demo UI
    Route::get('demo', function () {
        return view()->exists('layouts.dashboard_clean') 
            ? view('layouts.dashboard_clean') 
            : view('layouts.dashboard');
    })->name('demo');

    // ========================================
    // AUTHENTICATION ROUTES
    // ========================================
    Route::middleware('guest')->group(function () {
        // Login
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.form');
        Route::post('login', [AuthController::class, 'login'])
            ->name('login')
            ->middleware('throttle:login');
        
        // Registration
        Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
        
        // Patient Registration
        Route::get('register/patient', [AuthController::class, 'showRegisterPatient'])->name('showRegisterPatient');
        Route::post('registerPatient', [AuthController::class, 'registerPatient'])
            ->name('registerPatient')
            ->middleware('throttle:register');
        
        // Doctor Registration
        Route::get('register/doctor', [AuthController::class, 'showRegisterDoctor'])->name('showRegisterDoctor');
        Route::post('registerDoctor', [AuthController::class, 'registerDoctor'])
            ->name('registerDoctor')
            ->middleware('throttle:register');
    });

    // Logout
    Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:web');

    // ========================================
    // AUTHENTICATED ROUTES (Control Panel)
    // ========================================
    Route::prefix('control')->middleware('auth:web')->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

        // Password Management
        Route::get('change-password', [UserController::class, 'changePassword'])->name('changePassword');
        Route::post('change-password-saved', [UserController::class, 'changePasswordSaved'])->name('changePasswordSaved');

        // ========================================
        // RESOURCE ROUTES (Admin/Doctor/Patient Management)
        // ========================================
        
        // Patient Management (Admin & Doctor only)
        Route::middleware('role:Admin|Doctor')->group(function () {
            Route::resource('patient', PatientController::class);
        });

        // Patient Profile (Self-editing)
        Route::get('profile/patient/edit/{patient}', [PatientController::class, 'editProfile'])->name('profile.patient.edit');
        Route::put('profile/patient/update/{patient}', [PatientController::class, 'updateProfile'])->name('profile.patient.update');

        // Doctor Management (Admin, Patient & Doctor can view)
        Route::middleware('role:Admin|Patient|Doctor')->group(function () {
            Route::resource('doctor', DoctorController::class);
        });

        // Doctor Approval Management (Admin only)
        Route::middleware('role:Admin')->group(function () {
            Route::get('doctors/pending', [DoctorController::class, 'pendingApprovals'])->name('doctors.pending');
            Route::post('doctors/{doctor}/approve', [DoctorController::class, 'approve'])->name('doctors.approve');
            Route::post('doctors/{doctor}/reject', [DoctorController::class, 'reject'])->name('doctors.reject');
        });

        // Doctor Profile (Self-editing)
        Route::get('profile/doctor/edit/{doctor}', [DoctorController::class, 'editProfile'])->name('profile.doctor.edit');
        Route::put('profile/doctor/update/{doctor}', [DoctorController::class, 'updateProfile'])->name('profile.doctor.update');

        // Therapy Management (All roles)
        Route::middleware('role:Admin|Doctor|Patient')->group(function () {
            Route::resource('therapy', TherapyController::class);
            Route::get('therapy/create/{patient}', [TherapyController::class, 'create'])->name('therapy-create');
            Route::get('/therapies/playlist', [TherapyController::class, 'playlist'])->name('playlist');
        });

        // Admin-only Therapy Routes
        Route::middleware('role:Admin')->group(function () {
            Route::get('therapy/admin/create', [TherapyController::class, 'admin_therapy_create'])->name('admin_therapy_create');
            Route::post('therapy/admin/store', [TherapyController::class, 'admin_therapy_store'])->name('admin_therapy_store');
        });

        // ========================================
        // FEEDBACK ROUTES
        // ========================================
        Route::prefix('feedback')->group(function () {
            // Create Feedback (All authenticated users)
            Route::middleware('role:Admin|Patient|Doctor')->group(function () {
                Route::get('/create', [FeedbackController::class, 'create'])->name('feedback');
                Route::post('/store', [FeedbackController::class, 'store'])->name('feedback.store');
            });

            // Admin Feedback Management
            Route::middleware('role:Admin')->group(function () {
                Route::get('/index', [FeedbackController::class, 'index'])->name('feedback-list');
                Route::get('/show/{feedback}', [FeedbackController::class, 'show'])->name('feedback.show');
                Route::delete('/delete/{feedback}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');
            });
        });

        // ========================================
        // BLOG MANAGEMENT (Admin only)
        // ========================================
        Route::prefix('blogs')->middleware('role:Admin')->group(function () {
            Route::get('list', [BlogController::class, 'list'])->name('blog.list');
            Route::get('create', [BlogController::class, 'create'])->name('blog.create');
            Route::post('store', [BlogController::class, 'store'])->name('blog.store');
            Route::get('edit/{blog}', [BlogController::class, 'edit'])->name('blog.edit');
            Route::post('update/{blog}', [BlogController::class, 'update'])->name('blog.update');
            Route::delete('{blog}', [BlogController::class, 'destroy'])->name('blog.destroy');
        });

        // ========================================
        // DOCTOR BOOKING & AVAILABILITY
        // ========================================
        Route::prefix('doctors')->middleware('role:Doctor')->group(function () {
            Route::get('/calendar', [DoctorController::class, 'calendar'])->name('doctors.calendar');
            Route::delete('/deletetime/{id}', [DoctorController::class, 'deleteTime'])->name('deletetime');
            Route::post('/addTimes', [DoctorController::class, 'addTimes'])->name('addTimes');
            Route::get('/booking', [DoctorController::class, 'patientBooking'])->name('doctors.booking.index');
            Route::post('/changeStatus/{id}/{status}', [DoctorController::class, 'doctorChangeStatus'])->name('doctorChangeStatus');
        });

        // ========================================
        // PATIENT BOOKING
        // ========================================
        Route::prefix('patients')->middleware('role:Patient')->group(function () {
            Route::get('/calendar/{id}', [BookingController::class, 'calendar'])->name('patients.calendar');
            Route::post('/addAppointment', [BookingController::class, 'addAppointment'])->name('addAppointment');
            Route::get('/booking', [BookingController::class, 'index'])->name('patients.booking.index');
            Route::post('/changeStatus/{id}/{status}', [BookingController::class, 'changeStatus'])->name('changeStatus');
        });
    });
});

// ========================================
// GLOBAL ROUTES (Outside localization)
// ========================================
Route::post('/control-music', [TherapyController::class, 'controlMusic'])->name('controlMusic');
Route::get('/fetch-therapies', [TherapyController::class, 'fetchTherapies'])->name('fetch-therapies');
Route::post('/get-peaks', [TherapyController::class, 'getPeaks'])->name('get-peaks');
Route::post('/save-peaks', [TherapyController::class, 'savePeaks'])->name('save-peaks');
Route::get('/getDiseases/{id}', [TherapyController::class, 'getDiseases'])->name('getDiseases');
Route::get('/therapy/{therapy}/audio', [TherapyController::class, 'getAudio'])->name('therapy.audio');

// ========================================
// DEVELOPMENT ROUTES (Demo/Testing)
// ========================================
Route::get('/demo/tailwind', function () {
    return view('demo.tailwind-showcase');
})->name('demo.tailwind');

Route::get('/demo/medical', function () {
    return view('demo.medical-dashboard');
})->name('demo.medical');
