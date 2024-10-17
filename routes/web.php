<?php

use App\Http\Controllers\TherapyController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
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
});
Route::get('/register', function () {
    return view('frontend/register');
});
Route::get('/contact-us', function () {
    return view('frontend/contact-us');
});
Route::get('/about-us', function () {
    return view('frontend/about-us');
});
// Auth

Route::get('/fetch-therapies', [TherapyController::class, 'fetchTherapies']);
Route::post('/get-peaks', [TherapyController::class, 'getPeaks']);
Route::post('/save-peaks', [TherapyController::class, 'savePeaks']);

Route::group([
    'prefix' => 'control',
], function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    Route::get('login', [AuthController::class, 'showLoginForm']);
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth:web'])->group(function () {
        Route::resource('patient', PatientController::class)->middleware('role:Admin|Doctor');
        Route::resource('doctor', DoctorController::class)->middleware('role:Admin|Patient');
        Route::resource('therapy', TherapyController::class)->middleware('role:Admin|Doctor|Patient');
        Route::get('/therapies/playlist', [TherapyController::class, 'playlist'])->name('playlist')->middleware('role:Admin|Doctor|Patient');
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
