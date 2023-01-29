<?php

use App\Http\Controllers\API\Device\AuthController;
use App\Http\Controllers\API\Device\DegisnationController;
use App\Http\Controllers\API\Device\DoctorController;
use App\Http\Controllers\API\Device\QualificationController;
use App\Http\Controllers\API\Device\RoleController;
use App\Http\Controllers\API\Device\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum', 'validate.user']], function () {
});

Route::get('qualifications', [QualificationController::class, 'index'])
    ->name('qualifications.index');
Route::get('qualifications/{qualification}', [QualificationController::class, 'show'])
    ->name('qualification.show');
Route::post('qualifications', [QualificationController::class, 'store'])
    ->name('qualification.store');
Route::put('qualifications/{qualification}', [QualificationController::class, 'update'])
    ->name('qualification.update');
Route::delete('qualifications/{qualification}', [QualificationController::class, 'delete'])
    ->name('qualification.delete');
Route::post('qualifications/bulk-create', [QualificationController::class, 'bulkStore'])
    ->name('qualification.store.bulk');
Route::post('qualifications/bulk-update', [QualificationController::class, 'bulkUpdate'])
    ->name('qualification.update.bulk');
Route::get('degisnations', [DegisnationController::class, 'index'])
    ->name('degisnations.index');
Route::get('degisnations/{degisnation}', [DegisnationController::class, 'show'])
    ->name('degisnation.show');
Route::post('degisnations', [DegisnationController::class, 'store'])
    ->name('degisnation.store');
Route::put('degisnations/{degisnation}', [DegisnationController::class, 'update'])
    ->name('degisnation.update');
Route::delete('degisnations/{degisnation}', [DegisnationController::class, 'delete'])
    ->name('degisnation.delete');
Route::post('degisnations/bulk-create', [DegisnationController::class, 'bulkStore'])
    ->name('degisnation.store.bulk');
Route::post('degisnations/bulk-update', [DegisnationController::class, 'bulkUpdate'])
    ->name('degisnation.update.bulk');
Route::get('doctors', [DoctorController::class, 'index'])
    ->name('doctors.index');
Route::get('doctors/{doctor}', [DoctorController::class, 'show'])
    ->name('doctor.show');
Route::post('doctors', [DoctorController::class, 'store'])
    ->name('doctor.store');
Route::put('doctors/{doctor}', [DoctorController::class, 'update'])
    ->name('doctor.update');
Route::delete('doctors/{doctor}', [DoctorController::class, 'delete'])
    ->name('doctor.delete');
Route::post('doctors/bulk-create', [DoctorController::class, 'bulkStore'])
    ->name('doctor.store.bulk');
Route::post('doctors/bulk-update', [DoctorController::class, 'bulkUpdate'])
    ->name('doctor.update.bulk');
Route::get('roles', [RoleController::class, 'index'])
    ->name('roles.index');
Route::get('roles/{role}', [RoleController::class, 'show'])
    ->name('role.show');
Route::post('roles', [RoleController::class, 'store'])
    ->name('role.store');
Route::put('roles/{role}', [RoleController::class, 'update'])
    ->name('role.update');
Route::delete('roles/{role}', [RoleController::class, 'delete'])
    ->name('role.delete');
Route::post('roles/bulk-create', [RoleController::class, 'bulkStore'])
    ->name('role.store.bulk');
Route::post('roles/bulk-update', [RoleController::class, 'bulkUpdate'])
    ->name('role.update.bulk');
Route::get('users', [UserController::class, 'index'])
    ->name('users.index');
Route::get('users/{user}', [UserController::class, 'show'])
    ->name('user.show');
Route::post('users', [UserController::class, 'store'])
    ->name('user.store');
Route::put('users/{user}', [UserController::class, 'update'])
    ->name('user.update');
Route::delete('users/{user}', [UserController::class, 'delete'])
    ->name('user.delete');
Route::post('users/bulk-create', [UserController::class, 'bulkStore'])
    ->name('user.store.bulk');
Route::post('users/bulk-update', [UserController::class, 'bulkUpdate'])
    ->name('user.update.bulk');

Route::post('register', [AuthController::class, 'register'])
    ->name('register');
Route::post('login', [AuthController::class, 'login'])
    ->name('login');
Route::post('logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth:sanctum');
Route::put('change-password', [AuthController::class, 'changePassword'])
    ->name('change.password')
    ->middleware(['auth:sanctum', 'validate.user']);
Route::post('forgot-password', [AuthController::class, 'forgotPassword'])
    ->name('forgot.password');
Route::post('validate-otp', [AuthController::class, 'validateResetPasswordOtp'])
    ->name('reset.password.validate.otp');
Route::put('reset-password', [AuthController::class, 'resetPassword'])
    ->name('reset.password');
