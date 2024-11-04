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

Route::get('/', function () {
    return view('frontend/home');
})->name('home');

Route::get('/contact-us', function () {
    return view('frontend/contact-us');
})->name('contact-us');
Route::get('/about-us', function () {
    return view('frontend/about-us');
})->name('about-us');

Route::get('/listenToMusic', function () {
    return view('frontend/listenToMusic');
});
Route::get('/listener-statistics', function () {
    return view('frontend/listener-statistics');
});
// Auth

Route::get('login', [AuthController::class, 'showLoginForm']);
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('registerPatient', [AuthController::class, 'registerPatient'])->name('registerPatient');

Route::get('/fetch-therapies', [TherapyController::class, 'fetchTherapies'])->name('fetch-therapies');
Route::post('/get-peaks', [TherapyController::class, 'getPeaks'])->name('get-peaks');
Route::post('/save-peaks', [TherapyController::class, 'savePeaks'])->name('save-peaks');

Route::group([
    'prefix' => 'control',
], function () {

    Route::middleware(['auth:web'])->group(function () {

        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

        Route::resource('patient', PatientController::class)->middleware('role:Admin|Doctor');
        Route::resource('doctor', DoctorController::class)->middleware('role:Admin|Patient');
        Route::resource('therapy', TherapyController::class)->middleware('role:Admin|Doctor|Patient');
        Route::get('/therapies/playlist', [TherapyController::class, 'playlist'])->name('playlist')->middleware('role:Admin|Doctor|Patient');

        // Feedback
        Route::get('/feedback/create', [FeedbackController::class,'create'])->name('feedback')->middleware('role:Patient');
        Route::post('/feedback/store', [FeedbackController::class,'store'])->name('feedback.store')->middleware('role:Patient');
        Route::get('/feedback/index', [FeedbackController::class,'index'])->name('feedback-list')->middleware('role:Admin|Patient');
        Route::get('/feedback/show/{feedback}', [FeedbackController::class,'show'])->name('feedback.show')->middleware('role:Admin|Patient');
        Route::delete('/feedback/delete/{feedback}', [FeedbackController::class,'destroy'])->name('feedback.destroy')->middleware('role:Admin');

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
