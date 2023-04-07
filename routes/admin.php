<?php

use App\Http\Controllers\Admin\AccomodationController;
use App\Http\Controllers\Admin\AccreditationController;
use App\Http\Controllers\Admin\ActiveQueryController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ConfirmedQueryController;
use App\Http\Controllers\Admin\DesignationController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\FileUploadController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\HospitalController;
use App\Http\Controllers\Admin\PatientTestimonyController;
use App\Http\Controllers\Admin\PushNotificationController;
use App\Http\Controllers\Admin\QueryController;
use App\Http\Controllers\Admin\SpecializationController;
use App\Http\Controllers\Admin\TagsController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Admin\TreatmentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WellnessCenterController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {

    Route::get('dashboard', [\App\Http\Controllers\Admin\HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('profile', [\App\Http\Controllers\Admin\HomeController::class, 'profile'])->name('profile.index');

//    ------------- Queries Route ----------- //

    Route::post('queries', [QueryController::class, 'store'])
        ->name('query.store')
        ->middleware(['permission:create_query']);
    Route::post('queries/bulk-create', [QueryController::class, 'bulkStore'])
        ->name('query.store.bulk')
        ->middleware(['permission:create_query']);
    Route::get('queries', [QueryController::class, 'index'])
        ->name('queries.index')
        ->middleware(['permission:read_query']);
    Route::get('queries/{query}', [QueryController::class, 'show'])
        ->name('query.show')
        ->middleware(['permission:read_query']);
    Route::put('queries/{query}', [QueryController::class, 'update'])
        ->name('query.update')
        ->middleware(['permission:update_query']);
    Route::delete('queries/{query}', [QueryController::class, 'delete'])
        ->name('query.delete')
        ->middleware(['permission:delete_query']);

    Route::get('confirmed-queries', [ConfirmedQueryController::class, 'index'])
        ->name('confirmed-queries.index');
    Route::get('confirmed-queries/{confirmedQuery}', [ConfirmedQueryController::class, 'show'])
        ->name('confirmedQuery.show');
    Route::post('confirmed-queries', [ConfirmedQueryController::class, 'store'])
        ->name('confirmedQuery.store');
    Route::put('confirmed-queries/{confirmedQuery}', [ConfirmedQueryController::class, 'update'])
        ->name('confirmedQuery.update');
    Route::delete('confirmed-queries/{confirmedQuery}', [ConfirmedQueryController::class, 'delete'])
        ->name('confirmedQuery.delete');

    Route::post('active-queries', [ActiveQueryController::class, 'store'])
        ->name('activeQuery.store');
    Route::put('active-queries/{activeQuery}', [ActiveQueryController::class, 'update'])
        ->name('activeQuery.update');
    Route::delete('active-queries/{activeQuery}', [ActiveQueryController::class, 'delete'])
        ->name('activeQuery.delete');

//    ------------ End Query Routes ----------------//


    Route::post('patient-testimonies', [PatientTestimonyController::class, 'store'])
        ->name('patientTestimony.store')
        ->middleware(['permission:create_patienttestimony']);
    Route::post('patient-testimonies/bulk-create', [PatientTestimonyController::class, 'bulkStore'])
        ->name('patientTestimony.store.bulk')
        ->middleware(['permission:create_patienttestimony']);
    Route::get('patient-testimonies', [PatientTestimonyController::class, 'index'])
        ->name('patient-testimonies.index')
        ->middleware(['permission:read_patienttestimony']);
    Route::get('patient-testimonies/{patientTestimony}', [PatientTestimonyController::class, 'show'])
        ->name('patientTestimony.show')
        ->middleware(['permission:read_patienttestimony']);
    Route::put('patient-testimonies/{patientTestimony}', [PatientTestimonyController::class, 'update'])
        ->name('patientTestimony.update')
        ->middleware(['permission:update_patienttestimony']);
    Route::post('patient-testimonies/bulk-update', [PatientTestimonyController::class, 'bulkUpdate'])
        ->name('patientTestimony.update.bulk')
        ->middleware(['permission:update_patienttestimony']);
    Route::delete('patient-testimonies/{patientTestimony}', [PatientTestimonyController::class, 'delete'])
        ->name('patientTestimony.delete')
        ->middleware(['permission:delete_patienttestimony']);

    Route::resource('wellness-centers', WellnessCenterController::class);

    Route::resource('accommodations', AccomodationController::class);

    Route::resource('tests', TestController::class);

    Route::resource('designations', DesignationController::class);

    Route::resource('treatments', TreatmentController::class);

    Route::resource('tags', TagsController::class);

    Route::resource('specializations', SpecializationController::class);

    Route::resource('hospitals', HospitalController::class);

    Route::get('patients/list', [UserController::class, 'listPatients'])->name('patient.index');
    Route::prefix('hcf')->group(function () {
        Route::get('list', [UserController::class, 'listModerators'])->name('moderators.index');
        Route::get('create', [UserController::class, 'createModerator'])->name('moderators.create');
        Route::post('store', [UserController::class, 'storeModerator'])->name('moderators.store');
        Route::get('edit/{user}', [UserController::class, 'editModerator'])->name('moderators.edit');
    });


    Route::post('accreditations', [AccreditationController::class, 'store'])
        ->name('accreditation.store')
        ->middleware(['permission:create_accreditation']);
    Route::get('accreditations', [AccreditationController::class, 'index'])
        ->name('accreditations.index')
        ->middleware(['permission:read_accreditation']);
    Route::get('accreditations/create', [AccreditationController::class, 'create'])
        ->name('accreditations.create');
    Route::get('accreditations/{accreditation}', [AccreditationController::class, 'show'])
        ->name('accreditation.show')
        ->middleware(['permission:read_accreditation']);
    Route::put('accreditations/{accreditation}', [AccreditationController::class, 'update'])
        ->name('accreditation.update')
        ->middleware(['permission:update_accreditation']);
    Route::delete('accreditations/{accreditation}', [AccreditationController::class, 'delete'])
        ->name('accreditation.delete')
        ->middleware(['permission:delete_accreditation']);


    Route::match(['GET', 'POST'], 'doctors/create', [DoctorController::class, 'store'])
        ->name('doctor.store')
        ->middleware(['permission:create_doctor']);
    Route::post('doctors/bulk-create', [DoctorController::class, 'bulkStore'])
        ->name('doctor.store.bulk')
        ->middleware(['permission:create_doctor']);
    Route::get('doctors', [DoctorController::class, 'index'])
        ->name('doctors.index')
        ->middleware(['permission:read_doctor']);
    Route::get('doctors/{doctor}', [DoctorController::class, 'show'])
        ->name('doctors.show')
        ->middleware(['permission:read_doctor']);
    Route::put('doctors/{doctor}', [DoctorController::class, 'update'])
        ->name('doctor.update')
        ->middleware(['permission:update_doctor']);
    Route::post('doctors/bulk-update', [DoctorController::class, 'bulkUpdate'])
        ->name('doctor.update.bulk')
        ->middleware(['permission:update_doctor']);
    Route::delete('doctors/{doctor}', [DoctorController::class, 'delete'])
        ->name('doctor.delete')
        ->middleware(['permission:delete_doctor']);
});

Route::resource('users', UserController::class);

Route::post('file-upload', [FileUploadController::class, 'upload'])
    ->name('file.upload')
    ->middleware(['auth:sanctum', 'validate.user']);

Route::post('push-notifications/add-device-id', [PushNotificationController::class, 'store'])
    ->name('pushNotification.add-device');
Route::post('push-notifications/remove-device-id', [PushNotificationController::class, 'removeDeviceId'])
    ->name('pushNotification.remove-device');

Route::any('register', [AuthController::class, 'register'])
    ->name('register');
Route::any('login', [AuthController::class, 'login'])
    ->name('login');
Route::get('logout', [AuthController::class, 'logout'])
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

Route::get('ajax-search/{table}', [HomeController::class, 'ajaxSearch'])->name('ajaxSearch');


Route::get('/', [HomeController::class, 'index'])->name('home');
