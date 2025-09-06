<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\API\HealthcareProfessionalController;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    // Appointments
    Route::get('appointments', [AppointmentController::class, 'index']);
    Route::get('/appointments/{id}', [AppointmentController::class, 'show']);
    Route::post('appointments', [AppointmentController::class, 'store']);
    Route::post('appointments/{id}/cancel', [AppointmentController::class, 'cancel']);

    // Healthcare Professionals
    Route::get('professionals', [HealthcareProfessionalController::class, 'index']);
    Route::get('professionals/{id}', [HealthcareProfessionalController::class, 'show']);
});
