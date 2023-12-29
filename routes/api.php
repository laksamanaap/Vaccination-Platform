<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SpotsController;
use App\Http\Controllers\VacinationController;
use App\Http\Controllers\ConsultationController;

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

// Auth
Route::post("v1/auth/login", [AuthController::class, 'loginUsers'])->name('loginUsers');
Route::post("v1/auth/logout", [AuthController::class, 'logoutUsers'])->name('logoutUsers');

// Request Consultation

Route::middleware(AuthMiddleware::class)->group(
    function(){

        // Consultations
        Route::post("v1/consultations", [ConsultationController::class, 'storeConsultation'])->name('storeConsultation');
        Route::get("v1/consultations", [ConsultationController::class, 'getConsultation'])->name('getConsultation');
    
        // Spots
        Route::get("v1/spots", [SpotsController::class, 'getVacinationSpots'])->name('getVacinationSpots');
        Route::get("v1/spots/{id}", [SpotsController::class, 'getDetailVacinationSpots'])->name('getDetailVacinationSpots');

        // Vacination
        Route::post("v1/vaccinations", [VacinationController::class, 'storeVaccination'])->name('storeVaccination');
        Route::get("v1/vaccinations", [VacinationController::class, 'getVaccination'])->name('getVaccination');


    }
);
