<?php

use App\Http\Controllers\API\Client\AuthController;
use App\Http\Controllers\API\Client\DoctorController;
use App\Http\Controllers\API\Client\FileUploadController;
use App\Http\Controllers\API\Client\HcfController;
use App\Http\Controllers\API\Client\HomeController;
use App\Http\Controllers\API\Client\HospitalController;
use App\Http\Controllers\API\Client\PatientFamilyController;
use App\Http\Controllers\API\Client\PushNotificationController;
use App\Http\Controllers\API\Client\QueryController;
use App\Http\Controllers\API\Client\TreatmentController;
use App\Http\Controllers\API\Client\UserController;
use App\Http\Controllers\API\Client\VideoConsultationController;
use App\Models\PatientFamilyDetails;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth:sanctum', 'validate.user', 'api']], function () {
    Route::apiResource('queries', QueryController::class)->except('show');
    Route::get('queries/{id}/{step}', [QueryController::class, 'show'])->name('queries.show');
    Route::post('upload-patient-response', [QueryController::class, 'updatePatientResponse']);
    Route::post('query-upload-visa', [QueryController::class, 'uploadVisa']);
    Route::get('confirmed-query', [QueryController::class, 'confirmedQueryDetail']);
    Route::get('hospitals/{id}/doctors', [HospitalController::class, 'doctors']);
    Route::apiResource('family',PatientFamilyController::class);
    Route::post('update-transaction-result', [QueryController::class, 'transactionSuccess']);
    Route::get('consultations', [VideoConsultationController::class, 'index']);
    Route::post('submit-consultation', [VideoConsultationController::class, 'store']);
    Route::post('update-firebase', [UserController::class, 'updateFirebase']);
    Route::post('update-avatar/{user}', [UserController::class, 'updateAvatar']);
    Route::post('update-language', [UserController::class, 'updateLanguage']);
    // Route::post('family', [PatientFamilyController::class, 'store']);
    Route::post('trigger-support-call', [PushNotificationController::class,'callHcf'])->name('placeHcfCall');

    Route::prefix('hcf')->group(function(){
        Route::get('patients', [HcfController::class, 'index']);
        Route::post('update-status/{query}', [HcfController::class, 'update']);
        Route::get('all-status/{query}', [HcfController::class, 'show']);
    });
});

Route::post('decline-call', [PushNotificationController::class,'disconnectCall'])->name('disconnectCall');


Route::get('home', [HomeController::class, 'modules'])->middleware('api');
Route::apiResource('doctors', DoctorController::class)->only(['index', 'show']);
Route::apiResource('treatments', TreatmentController::class)->only(['index', 'show']);
Route::apiResource('hospitals', HospitalController::class)->only(['index', 'show']);
Route::apiResource('specializations', HospitalController::class)->only(['index', 'show']);

Route::get('/search', [HomeController::class, 'searchHospitalDoctor'])->middleware('api');

Route::get('users', [UserController::class, 'index'])
    ->name('users.index');
Route::get('users/{user}', [UserController::class, 'show'])
    ->name('user.show');
Route::post('users', [UserController::class, 'store'])
    ->name('user.store');
Route::post('users/{user}', [UserController::class, 'update'])
    ->name('user.update');
Route::delete('users/{user}', [UserController::class, 'delete'])
    ->name('user.delete');
Route::post('login-with-bio', [AuthController::class, 'loginWithBio']);

Route::post('push-notifications/add-device-id', [PushNotificationController::class, 'store'])
    ->name('pushNotification.add-device');
Route::post('push-notifications/remove-device-id', [PushNotificationController::class, 'removeDeviceId'])
    ->name('pushNotification.remove-device');

Route::post('file-upload', [FileUploadController::class, 'upload'])
    ->name('file.upload')
    ->middleware(['auth:sanctum', 'validate.user']);

Route::post('register', [AuthController::class, 'register'])
    ->name('register');
Route::post('login', [AuthController::class, 'login'])
    ->name('login');
Route::post('validate-token', [AuthController::class, 'validateToken'])
    ->middleware('auth:sanctum');
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
Route::post('resend-otp', [AuthController::class, 'resendOtp'])
    ->name('resend.otp');
Route::post('check-otp', [AuthController::class, 'validateOtp']);
Route::put('reset-password', [AuthController::class, 'resetPassword'])
    ->name('reset.password');

Route::get('countries', [HomeController::class, 'getCountries']);

