<?php

use App\Http\Controllers\API\Admin\AuthController;
use App\Http\Controllers\API\Admin\DegisnationController;
use App\Http\Controllers\API\Admin\DoctorController;
use App\Http\Controllers\API\Admin\PermissionController;
use App\Http\Controllers\API\Admin\QualificationController;
use App\Http\Controllers\API\Admin\RoleController;
use App\Http\Controllers\API\Admin\RoleController;
use App\Http\Controllers\API\Admin\UserController;
use App\Http\Controllers\API\Admin\UserRoleController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum', 'validate.user']], function () {
    Route::get('roles', [RoleController::class, 'index'])
        ->name('role.index')
        ->middleware(['permission:manage_roles']);
    Route::get('roles/{role}', [RoleController::class, 'show'])
        ->name('role.show')
        ->middleware(['permission:manage_roles']);
    Route::post('roles', [RoleController::class, 'store'])
        ->name('role.store')
        ->middleware(['permission:manage_roles']);
    Route::put('roles/{role}', [RoleController::class, 'update'])
        ->name('role.update')
        ->middleware(['permission:manage_roles']);
    Route::delete('roles/{role}', [RoleController::class, 'delete'])
        ->name('role.delete')
        ->middleware(['permission:manage_roles']);
    Route::post('roles/bulk-create', [RoleController::class, 'bulkStore'])
        ->name('role.store.bulk')
        ->middleware(['permission:manage_roles']);
    Route::post('roles/bulk-update', [RoleController::class, 'bulkUpdate'])
        ->name('role.update.bulk')
        ->middleware(['permission:manage_roles']);

    Route::get('permissions', [PermissionController::class, 'index'])
        ->name('permission.index')
        ->middleware(['permission:manage_roles']);
    Route::get('permissions/{permission}', [PermissionController::class, 'show'])
        ->name('permission.show')
        ->middleware(['permission:manage_roles']);

    Route::post('users/assign-role', [UserRoleController::class, 'assignRole'])
        ->name('users.role.assign')
        ->middleware(['permission:manage_roles']);
    Route::get('users/{user}/roles', [UserRoleController::class, 'getAssignedRoles'])
        ->name('get.assigned.roles')
        ->middleware(['permission:manage_roles']);
    Route::put('users/{user}/update-role', [UserRoleController::class, 'updateUserRole'])
        ->name('users.role.update')
        ->middleware(['permission:manage_roles']);
    Route::post('users/bulk-assign-role', [UserRoleController::class, 'bulkAssignRole'])
        ->name('users.bulk.assign.roles')
        ->middleware(['permission:manage_roles']);
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
