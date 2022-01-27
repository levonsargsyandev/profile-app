<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\ExperienceController;
use \App\Http\Controllers\OrganizationController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::post('user', [UserController::class, 'updateUser']);
    Route::get('experiences', [ExperienceController::class, 'getExperiences']);
    Route::post('experiences', [ExperienceController::class, 'createExperience']);
    Route::get('organizations', [OrganizationController::class, 'getOrganizations']);
    Route::post('organizations', [OrganizationController::class, 'createOrganization']);
    Route::put('experiences/{experienceId}', [ExperienceController::class, 'updateExperience']);
    Route::put('organizations/{organizationId}', [OrganizationController::class, 'updateOrganization']);
});



Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout']);
