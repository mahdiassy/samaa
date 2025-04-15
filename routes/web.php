<?php

use App\Http\Controllers\TherapyController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AuthController;
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
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {

        Route::get('/', [HomeController::class, 'home'])->name('home');

        Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('contact-us');
        Route::post('/store-contact-us', [HomeController::class, 'storeContactUsForm'])->name('contactUs.store');

        Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('about-us');

        Route::get('/listenToMusic', function () {
            return view('frontend/listenToMusic');
        });
        Route::get('/listener-statistics', function () {
            return view('frontend/listener-statistics');
        });

        Route::get('/doctor-search', [DoctorController::class, 'search'])->name('doctor.search');

        // Auth
        Route::get('login', [AuthController::class, 'showLoginForm']);
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
        Route::post('registerPatient', [AuthController::class, 'registerPatient'])->name('registerPatient');

        Route::group([
            'prefix' => 'control',
        ], function () {

            Route::middleware(['auth:web'])->group(function () {

                Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

                Route::get('change-password', [UserController::class, 'changePassword'])->name('changePassword');
                Route::post('change-password-saved', [UserController::class, 'changePasswordSaved'])->name('changePasswordSaved');

                Route::resource('patient', PatientController::class)->middleware('role:Admin|Doctor');
                Route::get('profile/patient/edit/{patient}', [PatientController::class, 'editProfile'])->name('profile.patient.edit');
                Route::put('profile/patient/update/{patient}', [PatientController::class, 'updateProfile'])->name('profile.patient.update');

                Route::resource('doctor', DoctorController::class)->middleware('role:Admin|Patient|Doctor');
                Route::get('profile/doctor/edit/{doctor}', [DoctorController::class, 'editProfile'])->name('profile.doctor.edit');
                Route::put('profile/doctor/update/{doctor}', [DoctorController::class, 'updateProfile'])->name('profile.doctor.update');

                Route::resource('therapy', TherapyController::class)->middleware('role:Admin|Doctor|Patient');
                Route::get('therapy/create/{patient}', [TherapyController::class, 'create'])->middleware('role:Admin|Doctor|Patient')->name('therapy-create');
                Route::get('therapy/admin/create', [TherapyController::class, 'admin_therapy_create'])->middleware('role:Admin')->name('admin_therapy_create');
                Route::post('therapy/admin/store', [TherapyController::class, 'admin_therapy_store'])->middleware('role:Admin')->name('admin_therapy_store');
                Route::get('/therapies/playlist', [TherapyController::class, 'playlist'])->name('playlist')->middleware('role:Admin|Doctor|Patient');

                // Feedback
                Route::get('/feedback/create', [FeedbackController::class, 'create'])->name('feedback')->middleware('role:Patient|Doctor');
                Route::post('/feedback/store', [FeedbackController::class, 'store'])->name('feedback.store')->middleware('role:Patient|Doctor');
                Route::get('/feedback/index', [FeedbackController::class, 'index'])->name('feedback-list')->middleware('role:Admin|Patient|Doctor');
                Route::get('/feedback/show/{feedback}', [FeedbackController::class, 'show'])->name('feedback.show')->middleware('role:Admin|Patient|Doctor');
                Route::delete('/feedback/delete/{feedback}', [FeedbackController::class, 'destroy'])->name('feedback.destroy')->middleware('role:Admin');
            });

            // Availabilities
            Route::group([
                'prefix' => 'doctors',
                'middleware' => ['auth:web', 'role:Doctor']
            ], function () {
                Route::get('/calendar', [DoctorController::class, 'calendar'])->name('doctors.calendar');
                Route::delete('/deletetime/{id}', [DoctorController::class, 'deleteTime'])->name('deletetime');
                Route::post('/addTimes', [DoctorController::class, 'addTimes'])->name('addTimes');
                Route::get('/booking', [DoctorController::class, 'patientBooking'])->name('doctors.booking.index');
                Route::post('/changeStatus/{id}/{status}', [DoctorController::class, 'doctorChangeStatus'])->name('doctorChangeStatus');
            });

            // Booking
            Route::group([
                'prefix' => 'patients',
                'middleware' => ['auth:web', 'role:Patient']
            ], function () {
                Route::get('/calendar/{id}', [BookingController::class, 'calendar'])->name('patients.calendar');
                Route::post('/addAppointment', [BookingController::class, 'addAppointment'])->name('addAppointment');
                Route::get('/booking', [BookingController::class, 'index'])->name('patients.booking.index');
                Route::post('/changeStatus/{id}/{status}', [BookingController::class, 'changeStatus'])->name('changeStatus');
            });
        });
    }
);

Route::get('/fetch-therapies', [TherapyController::class, 'fetchTherapies'])->name('fetch-therapies');
Route::post('/get-peaks', [TherapyController::class, 'getPeaks'])->name('get-peaks');
Route::post('/save-peaks', [TherapyController::class, 'savePeaks'])->name('save-peaks');
Route::post('/control-music', [TherapyController::class, 'controlMusic'])->name('controlMusic');
Route::get('/getDiseases/{id}', [TherapyController::class, 'getDiseases'])->name('getDiseases');
