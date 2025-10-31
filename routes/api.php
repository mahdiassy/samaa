<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\DoctorController;
use App\Http\Controllers\api\PatientController;
use App\Http\Controllers\api\TherapyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ========================================
// PUBLIC API ROUTES
// ========================================
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('refresh', [AuthController::class, 'refresh']);
Route::post('logout', [AuthController::class, 'logout']);

// Sanctum authenticated route (example)
Route::middleware('auth:sanctum')->get('/user', fn(Request $request) => $request->user());

// ========================================
// AUTHENTICATED API ROUTES (JWT)
// ========================================
Route::middleware('auth:jwt')->group(function () {

    // ========================================
    // PATIENT API (Admin & Doctor only)
    // ========================================
    Route::prefix('patient')->middleware('role:Admin|Doctor')->group(function () {
        Route::get('/', [PatientController::class, 'index']);
        Route::get('/{id}', [PatientController::class, 'show']);
        Route::post('/store', [PatientController::class, 'store']);
        Route::post('/update/{id}', [PatientController::class, 'update']);
        Route::delete('/destroy/{id}', [PatientController::class, 'destroy']);
    });

    // ========================================
    // DOCTOR API (Admin only)
    // ========================================
    Route::prefix('doctor')->middleware('role:Admin')->group(function () {
        Route::get('/', [DoctorController::class, 'index']);
        Route::get('/{id}', [DoctorController::class, 'show']);
        Route::post('store', [DoctorController::class, 'store']);
        Route::post('update/{id}', [DoctorController::class, 'update']);
        Route::delete('destroy/{id}', [DoctorController::class, 'destroy']);
    });

    // ========================================
    // THERAPY API (All roles)
    // ========================================
    Route::prefix('therapy')->middleware('role:Admin|Doctor|Patient')->group(function () {
        Route::get('/', [TherapyController::class, 'index']);
        Route::get('/{id}', [TherapyController::class, 'show']);
        Route::post('store', [TherapyController::class, 'store']);
        Route::post('update/{id}', [TherapyController::class, 'update']);
        Route::delete('destroy/{id}', [TherapyController::class, 'destroy']);
    });
});
