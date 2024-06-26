<?php

use App\Http\Controllers\Admin\AccomodationController;
use App\Http\Controllers\Admin\AccreditationController;
use App\Http\Controllers\Admin\AdminNotificationsController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DesignationController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\FaqController;
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
use App\Http\Controllers\Admin\VideoConsultationController;
use App\Http\Controllers\Admin\WellnessCenterController;
use App\Models\AdminNotifications;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {

    Route::get('dashboard', [\App\Http\Controllers\Admin\HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('settings', [\App\Http\Controllers\Admin\HomeController::class, 'settings'])->name('settings.index');
    Route::post('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');

//    ------------- Queries Route ----------- //

    Route::post('queries', [QueryController::class, 'store'])
        ->name('query.store')
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
        ->name('query.destroy')
        ->middleware(['permission:delete_query']);
    Route::post('queries/confirm', [QueryController::class, 'confirmQuery'])
        ->name('query.confirm');
    Route::post('update-step/{id}', [QueryController::class, 'updateStep'])->name('query.update-step');
    Route::post('update-vil/{id}', [QueryController::class, 'updateVil'])->name('update-vil');


//    ------------ End Query Routes ----------------//

    Route::resource('patient-testimonies', PatientTestimonyController::class);
//    Route::post(, [PatientTestimonyController::class, 'store'])
//        ->name('patientTestimony.store')
//        ->middleware(['permission:create_patienttestimony']);
//    Route::get('patient-testimonies', [PatientTestimonyController::class, 'index'])
//        ->name('patient-testimonies.index')
//        ->middleware(['permission:read_patienttestimony']);
//    Route::get('patient-testimonies', [PatientTestimonyController::class, 'create']);
//    Route::get('patient-testimonies/{patientTestimony}', [PatientTestimonyController::class, 'show'])
//        ->name('patientTestimony.show')
//        ->middleware(['permission:read_patienttestimony']);
//    Route::put('patient-testimonies/{patientTestimony}', [PatientTestimonyController::class, 'update'])
//        ->name('patientTestimony.update')
//        ->middleware(['permission:update_patienttestimony']);
//    Route::delete('patient-testimonies/{patientTestimony}', [PatientTestimonyController::class, 'delete'])
//        ->name('patientTestimony.destroy')
//        ->middleware(['permission:delete_patienttestimony']);

    Route::resource('wellness-centers', WellnessCenterController::class);

    Route::resource('accommodations', AccomodationController::class);

    Route::resource('tests', TestController::class);

    Route::resource('designations', DesignationController::class);

    Route::resource('treatments', TreatmentController::class);

    Route::resource('tags', TagsController::class);

    Route::resource('specializations', SpecializationController::class);

    Route::resource('hospitals', HospitalController::class);
    Route::post('hospitals/{hospital}/gallery/add', [HospitalController::class, 'addGallery'])
        ->name('hospitals.gallery.add');

    Route::resource('faq', FaqController::class);

    Route::resource('video-consultation', VideoConsultationController::class);

    Route::get('patients/list', [UserController::class, 'listPatients'])->name('patient.index');
    Route::post('patients/make-active', [UserController::class, 'patientActive'])->name('patient.make-active');
    Route::prefix('hcf')->group(function () {
        Route::get('list', [UserController::class, 'listModerators'])->name('moderators.index');
        Route::get('create', [UserController::class, 'createModerator'])->name('moderators.create');
        Route::post('store', [UserController::class, 'storeModerator'])->name('moderators.store');
        Route::get('edit/{user}', [UserController::class, 'editModerator'])->name('moderators.edit');
        Route::post('update/{user}', [UserController::class, 'updateModerator'])->name('moderators.update');
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
        ->name('accreditations.destroy')
        ->middleware(['permission:delete_accreditation']);


    Route::match(['GET', 'POST'], 'doctors/create', [DoctorController::class, 'store'])
        ->name('doctor.store')
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
    Route::delete('doctors/{doctor}', [DoctorController::class, 'delete'])
        ->name('doctor.destroy')
        ->middleware(['permission:delete_doctor']);

    Route::resource('notification', AdminNotificationsController::class);
});

Route::get('consultation/{id}', [VideoConsultationController::class, 'startConsultation'])->name('start-consultation');

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


Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacyPolicy');
Route::match(['GET', 'POST'],'/request-delete', [HomeController::class, 'requestDelete'])->name('requestDelete');

Route::get('notify-message/{channelName}', [HomeController::class, 'sendNotifications']);
Route::get('test-fcm', [HomeController::class, 'sendNotifications']);
Route::post('change-language', [HomeController::class, 'switchLanguage'])->name('change.language');
Route::get('/', [HomeController::class, 'index'])->name('home');
