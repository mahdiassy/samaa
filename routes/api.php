<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\DoctorController;
use App\Http\Controllers\api\PatientController;
use App\Http\Controllers\api\TherapyController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register',[AuthController::class,'register']);
Route::post('login', [AuthController::class,'login']);
Route::post('refresh', [AuthController::class,'refresh']);
Route::post('logout', [AuthController::class,'logout']);

Route::middleware(['auth:jwt'])->group(function () {

    Route::group([
        'prefix' => 'patient',
        'middleware' => ['role:Admin|Doctor']
    ], function () {
        Route::get('/', [PatientController::class, 'index']);
        Route::get('/{id}', [PatientController::class, 'show']);
        Route::post('/store', [PatientController::class, 'store']);
        Route::post('/update/{id}', [PatientController::class, 'update']);
        Route::delete('/destroy/{id}', [PatientController::class, 'destroy']);
    });


    Route::group([
        'prefix' => 'doctor',
        'middleware' => ['role:Admin']
    ], function () {
        Route::get('/',[DoctorController::class,'index']);
        Route::get('/{id}',[DoctorController::class,'show']);
        Route::post('store',[DoctorController::class,'store']);
        Route::post('update/{id}',[DoctorController::class,'update']);
        Route::delete('destroy/{id}',[DoctorController::class,'destroy']);
    });

    Route::group([
        'prefix' => 'therapy',
        'middleware' => ['role:Admin|Doctor|Patient']
    ], function () {
        Route::get('/',[TherapyController::class,'index']);
        Route::get('/{id}',[TherapyController::class,'show']);
        Route::post('store',[TherapyController::class,'store']);
        Route::post('update/{id}',[TherapyController::class,'update']);
        Route::delete('destroy/{id}',[TherapyController::class,'destroy']);
    });
});
