<?php

use App\Http\Controllers\Api\Applicant\CreateApplicantController;
use App\Http\Controllers\Api\Applicant\GetAllApplicantsController;
use App\Http\Controllers\Api\Applicant\GetApplicantController;
use App\Http\Controllers\Api\AuthController;
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

Route::post('auth', AuthController::class)->name('api.auth');
Route::middleware(['api.auth'])->group(function () {
    Route::post('lead', CreateApplicantController::class)->name('lead.create');
    Route::get('lead/{id}', GetApplicantController::class)->name('lead.get');
    Route::get('leads', GetAllApplicantsController::class)->name('leads');
});
