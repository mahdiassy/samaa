<?php

use App\Http\Controllers\TherapyController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AuthController;
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
    return view('welcome');
});

// Auth

Route::get('login', [AuthController::class, 'showLoginForm']);
Route::post('login', [AuthController::class, 'login'])->name('login');;
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth:web'])->group(function () {
    Route::resource('patient', PatientController::class)->middleware('role:Admin|Doctor');
    Route::resource('doctor', DoctorController::class)->middleware('role:Admin');
    Route::resource('therapy', TherapyController::class)->middleware('role:Admin|Doctor|Patient');
    Route::get('/therapies/playlist', [TherapyController::class, 'playlist'])->name('playlist')->middleware('role:Admin|Doctor|Patient');
});
Route::get('/fetch-therapies', [TherapyController::class, 'fetchTherapies']);
Route::post('/get-peaks', [TherapyController::class, 'getPeaks']);
Route::post('/save-peaks', [TherapyController::class, 'savePeaks']);
