<?php

use App\Http\Controllers\API\Client\AccomodationController;
use App\Http\Controllers\API\Client\AccomodationFacitityController;
use App\Http\Controllers\API\Client\AccomodationTypeController;
use App\Http\Controllers\API\Client\AccreditationController;
use App\Http\Controllers\API\Client\AccreditationHospitalController;
use App\Http\Controllers\API\Client\ActiveQueryController;
use App\Http\Controllers\API\Client\AuthController;
use App\Http\Controllers\API\Client\ConfirmedQueryController;
use App\Http\Controllers\API\Client\DesignationController;
use App\Http\Controllers\API\Client\DetoxificationCategoryController;
use App\Http\Controllers\API\Client\DetoxificationWellnessController;
use App\Http\Controllers\API\Client\DoctorController;
use App\Http\Controllers\API\Client\DoctorHospitalController;
use App\Http\Controllers\API\Client\DoctorPatientTestimonialController;
use App\Http\Controllers\API\Client\DoctorSpecializationController;
use App\Http\Controllers\API\Client\DoctorTagController;
use App\Http\Controllers\API\Client\DoctorTreatmentController;
use App\Http\Controllers\API\Client\FacilityController;
use App\Http\Controllers\API\Client\HospitalController;
use App\Http\Controllers\API\Client\HospitalTagsController;
use App\Http\Controllers\API\Client\HospitalTreatmentController;
use App\Http\Controllers\API\Client\PastQueryController;
use App\Http\Controllers\API\Client\PatientDetailsController;
use App\Http\Controllers\API\Client\PatientFamilyController;
use App\Http\Controllers\API\Client\PatientFamilyDetailsController;
use App\Http\Controllers\API\Client\PatientTestimonyController;
use App\Http\Controllers\API\Client\PatientTestimonyTagController;
use App\Http\Controllers\API\Client\PushNotificationController;
use App\Http\Controllers\API\Client\QualificationController;
use App\Http\Controllers\API\Client\QueryController;
use App\Http\Controllers\API\Client\SpecializationController;
use App\Http\Controllers\API\Client\SpecializationTreatmentController;
use App\Http\Controllers\API\Client\TagsController;
use App\Http\Controllers\API\Client\TestController;
use App\Http\Controllers\API\Client\TreatmentController;
use App\Http\Controllers\API\Client\UserController;
use App\Http\Controllers\API\Client\WellnessCenterController;
use \App\Http\Controllers\API\Client\FileUploadController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum', 'validate.user']], function () {
    Route::get('home', [\App\Http\Controllers\API\Client\HomeController::class, 'modules']);
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
        ->name('query.delete')
        ->middleware(['permission:delete_query']);
    Route::post('queries/bulk-create', [QueryController::class, 'bulkStore'])
        ->name('query.store.bulk')
        ->middleware(['permission:create_query']);
    Route::post('queries/bulk-update', [QueryController::class, 'bulkUpdate'])
        ->name('query.update.bulk')
        ->middleware(['permission:update_query']);

    Route::post('hospital-treatments', [HospitalTreatmentController::class, 'store'])
        ->name('hospitalTreatment.store')
        ->middleware(['permission:create_hospitaltreatment']);
    Route::get('hospital-treatments', [HospitalTreatmentController::class, 'index'])
        ->name('hospital-treatments.index')
        ->middleware(['permission:read_hospitaltreatment']);
    Route::get('hospital-treatments/{hospitalTreatment}', [HospitalTreatmentController::class, 'show'])
        ->name('hospitalTreatment.show')
        ->middleware(['permission:read_hospitaltreatment']);
    Route::put('hospital-treatments/{hospitalTreatment}', [HospitalTreatmentController::class, 'update'])
        ->name('hospitalTreatment.update')
        ->middleware(['permission:update_hospitaltreatment']);
    Route::delete('hospital-treatments/{hospitalTreatment}', [HospitalTreatmentController::class, 'delete'])
        ->name('hospitalTreatment.delete')
        ->middleware(['permission:delete_hospitaltreatment']);
    Route::post('hospital-treatments/bulk-create', [HospitalTreatmentController::class, 'bulkStore'])
        ->name('hospitalTreatment.store.bulk')
        ->middleware(['permission:create_hospitaltreatment']);
    Route::post('hospital-treatments/bulk-update', [HospitalTreatmentController::class, 'bulkUpdate'])
        ->name('hospitalTreatment.update.bulk')
        ->middleware(['permission:update_hospitaltreatment']);

    Route::post('accreditation-hospitals', [AccreditationHospitalController::class, 'store'])
        ->name('accreditationHospital.store')
        ->middleware(['permission:create_accreditationhospital']);
    Route::get('accreditation-hospitals', [AccreditationHospitalController::class, 'index'])
        ->name('accreditation-hospitals.index')
        ->middleware(['permission:read_accreditationhospital']);
    Route::get('accreditation-hospitals/{accreditationHospital}', [AccreditationHospitalController::class, 'show'])
        ->name('accreditationHospital.show')
        ->middleware(['permission:read_accreditationhospital']);
    Route::put('accreditation-hospitals/{accreditationHospital}', [AccreditationHospitalController::class, 'update'])
        ->name('accreditationHospital.update')
        ->middleware(['permission:update_accreditationhospital']);
    Route::delete('accreditation-hospitals/{accreditationHospital}', [AccreditationHospitalController::class, 'delete'])
        ->name('accreditationHospital.delete')
        ->middleware(['permission:delete_accreditationhospital']);
    Route::post('accreditation-hospitals/bulk-create', [AccreditationHospitalController::class, 'bulkStore'])
        ->name('accreditationHospital.store.bulk')
        ->middleware(['permission:create_accreditationhospital']);
    Route::post('accreditation-hospitals/bulk-update', [AccreditationHospitalController::class, 'bulkUpdate'])
        ->name('accreditationHospital.update.bulk')
        ->middleware(['permission:update_accreditationhospital']);

    Route::post('doctor-patient-testimonials', [DoctorPatientTestimonialController::class, 'store'])
        ->name('doctorPatientTestimonial.store')
        ->middleware(['permission:create_doctorpatienttestimonial']);
    Route::get('doctor-patient-testimonials', [DoctorPatientTestimonialController::class, 'index'])
        ->name('doctor-patient-testimonials.index')
        ->middleware(['permission:read_doctorpatienttestimonial']);
    Route::get('doctor-patient-testimonials/{doctorPatientTestimonial}', [DoctorPatientTestimonialController::class, 'show'])
        ->name('doctorPatientTestimonial.show')
        ->middleware(['permission:read_doctorpatienttestimonial']);
    Route::put('doctor-patient-testimonials/{doctorPatientTestimonial}', [DoctorPatientTestimonialController::class, 'update'])
        ->name('doctorPatientTestimonial.update')
        ->middleware(['permission:update_doctorpatienttestimonial']);
    Route::delete('doctor-patient-testimonials/{doctorPatientTestimonial}', [DoctorPatientTestimonialController::class, 'delete'])
        ->name('doctorPatientTestimonial.delete')
        ->middleware(['permission:delete_doctorpatienttestimonial']);
    Route::post('doctor-patient-testimonials/bulk-create', [DoctorPatientTestimonialController::class, 'bulkStore'])
        ->name('doctorPatientTestimonial.store.bulk')
        ->middleware(['permission:create_doctorpatienttestimonial']);
    Route::post('doctor-patient-testimonials/bulk-update', [DoctorPatientTestimonialController::class, 'bulkUpdate'])
        ->name('doctorPatientTestimonial.update.bulk')
        ->middleware(['permission:update_doctorpatienttestimonial']);

    Route::post('doctor-tags', [DoctorTagController::class, 'store'])
        ->name('doctorTag.store')
        ->middleware(['permission:create_doctortag']);
    Route::get('doctor-tags', [DoctorTagController::class, 'index'])
        ->name('doctor-tags.index')
        ->middleware(['permission:read_doctortag']);
    Route::get('doctor-tags/{doctorTag}', [DoctorTagController::class, 'show'])
        ->name('doctorTag.show')
        ->middleware(['permission:read_doctortag']);
    Route::put('doctor-tags/{doctorTag}', [DoctorTagController::class, 'update'])
        ->name('doctorTag.update')
        ->middleware(['permission:update_doctortag']);
    Route::delete('doctor-tags/{doctorTag}', [DoctorTagController::class, 'delete'])
        ->name('doctorTag.delete')
        ->middleware(['permission:delete_doctortag']);
    Route::post('doctor-tags/bulk-create', [DoctorTagController::class, 'bulkStore'])
        ->name('doctorTag.store.bulk')
        ->middleware(['permission:create_doctortag']);
    Route::post('doctor-tags/bulk-update', [DoctorTagController::class, 'bulkUpdate'])
        ->name('doctorTag.update.bulk')
        ->middleware(['permission:update_doctortag']);

    Route::post('doctor-specializations', [DoctorSpecializationController::class, 'store'])
        ->name('doctorSpecialization.store')
        ->middleware(['permission:create_doctorspecialization']);
    Route::get('doctor-specializations', [DoctorSpecializationController::class, 'index'])
        ->name('doctor-specializations.index')
        ->middleware(['permission:read_doctorspecialization']);
    Route::get('doctor-specializations/{doctorSpecialization}', [DoctorSpecializationController::class, 'show'])
        ->name('doctorSpecialization.show')
        ->middleware(['permission:read_doctorspecialization']);
    Route::put('doctor-specializations/{doctorSpecialization}', [DoctorSpecializationController::class, 'update'])
        ->name('doctorSpecialization.update')
        ->middleware(['permission:update_doctorspecialization']);
    Route::delete('doctor-specializations/{doctorSpecialization}', [DoctorSpecializationController::class, 'delete'])
        ->name('doctorSpecialization.delete')
        ->middleware(['permission:delete_doctorspecialization']);
    Route::post('doctor-specializations/bulk-create', [DoctorSpecializationController::class, 'bulkStore'])
        ->name('doctorSpecialization.store.bulk')
        ->middleware(['permission:create_doctorspecialization']);
    Route::post('doctor-specializations/bulk-update', [DoctorSpecializationController::class, 'bulkUpdate'])
        ->name('doctorSpecialization.update.bulk')
        ->middleware(['permission:update_doctorspecialization']);

    Route::post('doctor-hospitals', [DoctorHospitalController::class, 'store'])
        ->name('doctorHospital.store')
        ->middleware(['permission:create_doctorhospital']);
    Route::get('doctor-hospitals', [DoctorHospitalController::class, 'index'])
        ->name('doctor-hospitals.index')
        ->middleware(['permission:read_doctorhospital']);
    Route::get('doctor-hospitals/{doctorHospital}', [DoctorHospitalController::class, 'show'])
        ->name('doctorHospital.show')
        ->middleware(['permission:read_doctorhospital']);
    Route::put('doctor-hospitals/{doctorHospital}', [DoctorHospitalController::class, 'update'])
        ->name('doctorHospital.update')
        ->middleware(['permission:update_doctorhospital']);
    Route::delete('doctor-hospitals/{doctorHospital}', [DoctorHospitalController::class, 'delete'])
        ->name('doctorHospital.delete')
        ->middleware(['permission:delete_doctorhospital']);
    Route::post('doctor-hospitals/bulk-create', [DoctorHospitalController::class, 'bulkStore'])
        ->name('doctorHospital.store.bulk')
        ->middleware(['permission:create_doctorhospital']);
    Route::post('doctor-hospitals/bulk-update', [DoctorHospitalController::class, 'bulkUpdate'])
        ->name('doctorHospital.update.bulk')
        ->middleware(['permission:update_doctorhospital']);

    Route::post('patient-testimony-tags', [PatientTestimonyTagController::class, 'store'])
        ->name('patientTestimonyTag.store')
        ->middleware(['permission:create_patienttestimonytag']);
    Route::get('patient-testimony-tags', [PatientTestimonyTagController::class, 'index'])
        ->name('patient-testimony-tags.index')
        ->middleware(['permission:read_patienttestimonytag']);
    Route::get('patient-testimony-tags/{patientTestimonyTag}', [PatientTestimonyTagController::class, 'show'])
        ->name('patientTestimonyTag.show')
        ->middleware(['permission:read_patienttestimonytag']);
    Route::put('patient-testimony-tags/{patientTestimonyTag}', [PatientTestimonyTagController::class, 'update'])
        ->name('patientTestimonyTag.update')
        ->middleware(['permission:update_patienttestimonytag']);
    Route::delete('patient-testimony-tags/{patientTestimonyTag}', [PatientTestimonyTagController::class, 'delete'])
        ->name('patientTestimonyTag.delete')
        ->middleware(['permission:delete_patienttestimonytag']);
    Route::post('patient-testimony-tags/bulk-create', [PatientTestimonyTagController::class, 'bulkStore'])
        ->name('patientTestimonyTag.store.bulk')
        ->middleware(['permission:create_patienttestimonytag']);
    Route::post('patient-testimony-tags/bulk-update', [PatientTestimonyTagController::class, 'bulkUpdate'])
        ->name('patientTestimonyTag.update.bulk')
        ->middleware(['permission:update_patienttestimonytag']);

    Route::post('patient-testimonies', [PatientTestimonyController::class, 'store'])
        ->name('patientTestimony.store')
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
    Route::delete('patient-testimonies/{patientTestimony}', [PatientTestimonyController::class, 'delete'])
        ->name('patientTestimony.delete')
        ->middleware(['permission:delete_patienttestimony']);
    Route::post('patient-testimonies/bulk-create', [PatientTestimonyController::class, 'bulkStore'])
        ->name('patientTestimony.store.bulk')
        ->middleware(['permission:create_patienttestimony']);
    Route::post('patient-testimonies/bulk-update', [PatientTestimonyController::class, 'bulkUpdate'])
        ->name('patientTestimony.update.bulk')
        ->middleware(['permission:update_patienttestimony']);

    Route::post('detoxification-wellnesses', [DetoxificationWellnessController::class, 'store'])
        ->name('detoxificationWellness.store')
        ->middleware(['permission:create_detoxificationwellness']);
    Route::get('detoxification-wellnesses', [DetoxificationWellnessController::class, 'index'])
        ->name('detoxification-wellnesses.index')
        ->middleware(['permission:read_detoxificationwellness']);
    Route::get('detoxification-wellnesses/{detoxificationWellness}', [DetoxificationWellnessController::class, 'show'])
        ->name('detoxificationWellness.show')
        ->middleware(['permission:read_detoxificationwellness']);
    Route::put('detoxification-wellnesses/{detoxificationWellness}', [DetoxificationWellnessController::class, 'update'])
        ->name('detoxificationWellness.update')
        ->middleware(['permission:update_detoxificationwellness']);
    Route::delete('detoxification-wellnesses/{detoxificationWellness}', [DetoxificationWellnessController::class, 'delete'])
        ->name('detoxificationWellness.delete')
        ->middleware(['permission:delete_detoxificationwellness']);
    Route::post('detoxification-wellnesses/bulk-create', [DetoxificationWellnessController::class, 'bulkStore'])
        ->name('detoxificationWellness.store.bulk')
        ->middleware(['permission:create_detoxificationwellness']);
    Route::post('detoxification-wellnesses/bulk-update', [DetoxificationWellnessController::class, 'bulkUpdate'])
        ->name('detoxificationWellness.update.bulk')
        ->middleware(['permission:update_detoxificationwellness']);

    Route::post('detoxification-categories', [DetoxificationCategoryController::class, 'store'])
        ->name('detoxificationCategory.store')
        ->middleware(['permission:create_detoxificationcategory']);
    Route::get('detoxification-categories', [DetoxificationCategoryController::class, 'index'])
        ->name('detoxification-categories.index')
        ->middleware(['permission:read_detoxificationcategory']);
    Route::get('detoxification-categories/{detoxificationCategory}', [DetoxificationCategoryController::class, 'show'])
        ->name('detoxificationCategory.show')
        ->middleware(['permission:read_detoxificationcategory']);
    Route::put('detoxification-categories/{detoxificationCategory}', [DetoxificationCategoryController::class, 'update'])
        ->name('detoxificationCategory.update')
        ->middleware(['permission:update_detoxificationcategory']);
    Route::delete('detoxification-categories/{detoxificationCategory}', [DetoxificationCategoryController::class, 'delete'])
        ->name('detoxificationCategory.delete')
        ->middleware(['permission:delete_detoxificationcategory']);
    Route::post('detoxification-categories/bulk-create', [DetoxificationCategoryController::class, 'bulkStore'])
        ->name('detoxificationCategory.store.bulk')
        ->middleware(['permission:create_detoxificationcategory']);
    Route::post('detoxification-categories/bulk-update', [DetoxificationCategoryController::class, 'bulkUpdate'])
        ->name('detoxificationCategory.update.bulk')
        ->middleware(['permission:update_detoxificationcategory']);

    Route::post('wellness-centers', [WellnessCenterController::class, 'store'])
        ->name('wellnessCenter.store')
        ->middleware(['permission:create_wellnesscenter']);
    Route::get('wellness-centers', [WellnessCenterController::class, 'index'])
        ->name('wellness-centers.index')
        ->middleware(['permission:read_wellnesscenter']);
    Route::get('wellness-centers/{wellnessCenter}', [WellnessCenterController::class, 'show'])
        ->name('wellnessCenter.show')
        ->middleware(['permission:read_wellnesscenter']);
    Route::put('wellness-centers/{wellnessCenter}', [WellnessCenterController::class, 'update'])
        ->name('wellnessCenter.update')
        ->middleware(['permission:update_wellnesscenter']);
    Route::delete('wellness-centers/{wellnessCenter}', [WellnessCenterController::class, 'delete'])
        ->name('wellnessCenter.delete')
        ->middleware(['permission:delete_wellnesscenter']);
    Route::post('wellness-centers/bulk-create', [WellnessCenterController::class, 'bulkStore'])
        ->name('wellnessCenter.store.bulk')
        ->middleware(['permission:create_wellnesscenter']);
    Route::post('wellness-centers/bulk-update', [WellnessCenterController::class, 'bulkUpdate'])
        ->name('wellnessCenter.update.bulk')
        ->middleware(['permission:update_wellnesscenter']);

    Route::post('accomodation-facitities', [AccomodationFacitityController::class, 'store'])
        ->name('accomodationFacitity.store')
        ->middleware(['permission:create_accomodationfacitity']);
    Route::get('accomodation-facitities', [AccomodationFacitityController::class, 'index'])
        ->name('accomodation-facitities.index')
        ->middleware(['permission:read_accomodationfacitity']);
    Route::get('accomodation-facitities/{accomodationFacitity}', [AccomodationFacitityController::class, 'show'])
        ->name('accomodationFacitity.show')
        ->middleware(['permission:read_accomodationfacitity']);
    Route::put('accomodation-facitities/{accomodationFacitity}', [AccomodationFacitityController::class, 'update'])
        ->name('accomodationFacitity.update')
        ->middleware(['permission:update_accomodationfacitity']);
    Route::delete('accomodation-facitities/{accomodationFacitity}', [AccomodationFacitityController::class, 'delete'])
        ->name('accomodationFacitity.delete')
        ->middleware(['permission:delete_accomodationfacitity']);
    Route::post('accomodation-facitities/bulk-create', [AccomodationFacitityController::class, 'bulkStore'])
        ->name('accomodationFacitity.store.bulk')
        ->middleware(['permission:create_accomodationfacitity']);
    Route::post('accomodation-facitities/bulk-update', [AccomodationFacitityController::class, 'bulkUpdate'])
        ->name('accomodationFacitity.update.bulk')
        ->middleware(['permission:update_accomodationfacitity']);

    Route::post('facilities', [FacilityController::class, 'store'])
        ->name('facility.store')
        ->middleware(['permission:create_facility']);
    Route::get('facilities', [FacilityController::class, 'index'])
        ->name('facilities.index')
        ->middleware(['permission:read_facility']);
    Route::get('facilities/{facility}', [FacilityController::class, 'show'])
        ->name('facility.show')
        ->middleware(['permission:read_facility']);
    Route::put('facilities/{facility}', [FacilityController::class, 'update'])
        ->name('facility.update')
        ->middleware(['permission:update_facility']);
    Route::delete('facilities/{facility}', [FacilityController::class, 'delete'])
        ->name('facility.delete')
        ->middleware(['permission:delete_facility']);
    Route::post('facilities/bulk-create', [FacilityController::class, 'bulkStore'])
        ->name('facility.store.bulk')
        ->middleware(['permission:create_facility']);
    Route::post('facilities/bulk-update', [FacilityController::class, 'bulkUpdate'])
        ->name('facility.update.bulk')
        ->middleware(['permission:update_facility']);

    Route::post('accomodation-types', [AccomodationTypeController::class, 'store'])
        ->name('accomodationType.store')
        ->middleware(['permission:create_accomodationtype']);
    Route::get('accomodation-types', [AccomodationTypeController::class, 'index'])
        ->name('accomodation-types.index')
        ->middleware(['permission:read_accomodationtype']);
    Route::get('accomodation-types/{accomodationType}', [AccomodationTypeController::class, 'show'])
        ->name('accomodationType.show')
        ->middleware(['permission:read_accomodationtype']);
    Route::put('accomodation-types/{accomodationType}', [AccomodationTypeController::class, 'update'])
        ->name('accomodationType.update')
        ->middleware(['permission:update_accomodationtype']);
    Route::delete('accomodation-types/{accomodationType}', [AccomodationTypeController::class, 'delete'])
        ->name('accomodationType.delete')
        ->middleware(['permission:delete_accomodationtype']);
    Route::post('accomodation-types/bulk-create', [AccomodationTypeController::class, 'bulkStore'])
        ->name('accomodationType.store.bulk')
        ->middleware(['permission:create_accomodationtype']);
    Route::post('accomodation-types/bulk-update', [AccomodationTypeController::class, 'bulkUpdate'])
        ->name('accomodationType.update.bulk')
        ->middleware(['permission:update_accomodationtype']);

    Route::post('accomodations', [AccomodationController::class, 'store'])
        ->name('accomodation.store')
        ->middleware(['permission:create_accomodation']);
    Route::get('accomodations', [AccomodationController::class, 'index'])
        ->name('accomodations.index')
        ->middleware(['permission:read_accomodation']);
    Route::get('accomodations/{accomodation}', [AccomodationController::class, 'show'])
        ->name('accomodation.show')
        ->middleware(['permission:read_accomodation']);
    Route::put('accomodations/{accomodation}', [AccomodationController::class, 'update'])
        ->name('accomodation.update')
        ->middleware(['permission:update_accomodation']);
    Route::delete('accomodations/{accomodation}', [AccomodationController::class, 'delete'])
        ->name('accomodation.delete')
        ->middleware(['permission:delete_accomodation']);
    Route::post('accomodations/bulk-create', [AccomodationController::class, 'bulkStore'])
        ->name('accomodation.store.bulk')
        ->middleware(['permission:create_accomodation']);
    Route::post('accomodations/bulk-update', [AccomodationController::class, 'bulkUpdate'])
        ->name('accomodation.update.bulk')
        ->middleware(['permission:update_accomodation']);

    Route::post('doctor-treatments', [DoctorTreatmentController::class, 'store'])
        ->name('doctorTreatment.store')
        ->middleware(['permission:create_doctortreatment']);
    Route::get('doctor-treatments', [DoctorTreatmentController::class, 'index'])
        ->name('doctor-treatments.index')
        ->middleware(['permission:read_doctortreatment']);
    Route::get('doctor-treatments/{doctorTreatment}', [DoctorTreatmentController::class, 'show'])
        ->name('doctorTreatment.show')
        ->middleware(['permission:read_doctortreatment']);
    Route::put('doctor-treatments/{doctorTreatment}', [DoctorTreatmentController::class, 'update'])
        ->name('doctorTreatment.update')
        ->middleware(['permission:update_doctortreatment']);
    Route::delete('doctor-treatments/{doctorTreatment}', [DoctorTreatmentController::class, 'delete'])
        ->name('doctorTreatment.delete')
        ->middleware(['permission:delete_doctortreatment']);
    Route::post('doctor-treatments/bulk-create', [DoctorTreatmentController::class, 'bulkStore'])
        ->name('doctorTreatment.store.bulk')
        ->middleware(['permission:create_doctortreatment']);
    Route::post('doctor-treatments/bulk-update', [DoctorTreatmentController::class, 'bulkUpdate'])
        ->name('doctorTreatment.update.bulk')
        ->middleware(['permission:update_doctortreatment']);

    Route::post('specialization-treatments', [SpecializationTreatmentController::class, 'store'])
        ->name('specializationTreatment.store')
        ->middleware(['permission:create_specializationtreatment']);
    Route::get('specialization-treatments', [SpecializationTreatmentController::class, 'index'])
        ->name('specialization-treatments.index')
        ->middleware(['permission:read_specializationtreatment']);
    Route::get('specialization-treatments/{specializationTreatment}', [SpecializationTreatmentController::class, 'show'])
        ->name('specializationTreatment.show')
        ->middleware(['permission:read_specializationtreatment']);
    Route::put('specialization-treatments/{specializationTreatment}', [SpecializationTreatmentController::class, 'update'])
        ->name('specializationTreatment.update')
        ->middleware(['permission:update_specializationtreatment']);
    Route::delete('specialization-treatments/{specializationTreatment}', [SpecializationTreatmentController::class, 'delete'])
        ->name('specializationTreatment.delete')
        ->middleware(['permission:delete_specializationtreatment']);
    Route::post('specialization-treatments/bulk-create', [SpecializationTreatmentController::class, 'bulkStore'])
        ->name('specializationTreatment.store.bulk')
        ->middleware(['permission:create_specializationtreatment']);
    Route::post('specialization-treatments/bulk-update', [SpecializationTreatmentController::class, 'bulkUpdate'])
        ->name('specializationTreatment.update.bulk')
        ->middleware(['permission:update_specializationtreatment']);

    Route::post('tests', [TestController::class, 'store'])
        ->name('test.store')
        ->middleware(['permission:create_test']);
    Route::get('tests', [TestController::class, 'index'])
        ->name('tests.index')
        ->middleware(['permission:read_test']);
    Route::get('tests/{test}', [TestController::class, 'show'])
        ->name('test.show')
        ->middleware(['permission:read_test']);
    Route::put('tests/{test}', [TestController::class, 'update'])
        ->name('test.update')
        ->middleware(['permission:update_test']);
    Route::delete('tests/{test}', [TestController::class, 'delete'])
        ->name('test.delete')
        ->middleware(['permission:delete_test']);
    Route::post('tests/bulk-create', [TestController::class, 'bulkStore'])
        ->name('test.store.bulk')
        ->middleware(['permission:create_test']);
    Route::post('tests/bulk-update', [TestController::class, 'bulkUpdate'])
        ->name('test.update.bulk')
        ->middleware(['permission:update_test']);

    Route::post('treatments', [TreatmentController::class, 'store'])
        ->name('treatment.store')
        ->middleware(['permission:create_treatment']);
    Route::get('treatments', [TreatmentController::class, 'index'])
        ->name('treatments.index')
        ->middleware(['permission:read_treatment']);
    Route::get('treatments/{treatment}', [TreatmentController::class, 'show'])
        ->name('treatment.show')
        ->middleware(['permission:read_treatment']);
    Route::put('treatments/{treatment}', [TreatmentController::class, 'update'])
        ->name('treatment.update')
        ->middleware(['permission:update_treatment']);
    Route::delete('treatments/{treatment}', [TreatmentController::class, 'delete'])
        ->name('treatment.delete')
        ->middleware(['permission:delete_treatment']);
    Route::post('treatments/bulk-create', [TreatmentController::class, 'bulkStore'])
        ->name('treatment.store.bulk')
        ->middleware(['permission:create_treatment']);
    Route::post('treatments/bulk-update', [TreatmentController::class, 'bulkUpdate'])
        ->name('treatment.update.bulk')
        ->middleware(['permission:update_treatment']);

    Route::post('hospital-tags', [HospitalTagsController::class, 'store'])
        ->name('hospitalTags.store')
        ->middleware(['permission:create_hospitaltags']);
    Route::get('hospital-tags', [HospitalTagsController::class, 'index'])
        ->name('hospital-tags.index')
        ->middleware(['permission:read_hospitaltags']);
    Route::get('hospital-tags/{hospitalTags}', [HospitalTagsController::class, 'show'])
        ->name('hospitalTags.show')
        ->middleware(['permission:read_hospitaltags']);
    Route::put('hospital-tags/{hospitalTags}', [HospitalTagsController::class, 'update'])
        ->name('hospitalTags.update')
        ->middleware(['permission:update_hospitaltags']);
    Route::delete('hospital-tags/{hospitalTags}', [HospitalTagsController::class, 'delete'])
        ->name('hospitalTags.delete')
        ->middleware(['permission:delete_hospitaltags']);
    Route::post('hospital-tags/bulk-create', [HospitalTagsController::class, 'bulkStore'])
        ->name('hospitalTags.store.bulk')
        ->middleware(['permission:create_hospitaltags']);
    Route::post('hospital-tags/bulk-update', [HospitalTagsController::class, 'bulkUpdate'])
        ->name('hospitalTags.update.bulk')
        ->middleware(['permission:update_hospitaltags']);

    Route::post('tags', [TagsController::class, 'store'])
        ->name('tags.store')
        ->middleware(['permission:create_tags']);
    Route::get('tags', [TagsController::class, 'index'])
        ->name('tags.index')
        ->middleware(['permission:read_tags']);
    Route::get('tags/{tags}', [TagsController::class, 'show'])
        ->name('tags.show')
        ->middleware(['permission:read_tags']);
    Route::put('tags/{tags}', [TagsController::class, 'update'])
        ->name('tags.update')
        ->middleware(['permission:update_tags']);
    Route::delete('tags/{tags}', [TagsController::class, 'delete'])
        ->name('tags.delete')
        ->middleware(['permission:delete_tags']);
    Route::post('tags/bulk-create', [TagsController::class, 'bulkStore'])
        ->name('tags.store.bulk')
        ->middleware(['permission:create_tags']);
    Route::post('tags/bulk-update', [TagsController::class, 'bulkUpdate'])
        ->name('tags.update.bulk')
        ->middleware(['permission:update_tags']);

    Route::post('accreditations', [AccreditationController::class, 'store'])
        ->name('accreditation.store')
        ->middleware(['permission:create_accreditation']);
    Route::get('accreditations', [AccreditationController::class, 'index'])
        ->name('accreditations.index')
        ->middleware(['permission:read_accreditation']);
    Route::get('accreditations/{accreditation}', [AccreditationController::class, 'show'])
        ->name('accreditation.show')
        ->middleware(['permission:read_accreditation']);
    Route::put('accreditations/{accreditation}', [AccreditationController::class, 'update'])
        ->name('accreditation.update')
        ->middleware(['permission:update_accreditation']);
    Route::delete('accreditations/{accreditation}', [AccreditationController::class, 'delete'])
        ->name('accreditation.delete')
        ->middleware(['permission:delete_accreditation']);
    Route::post('accreditations/bulk-create', [AccreditationController::class, 'bulkStore'])
        ->name('accreditation.store.bulk')
        ->middleware(['permission:create_accreditation']);
    Route::post('accreditations/bulk-update', [AccreditationController::class, 'bulkUpdate'])
        ->name('accreditation.update.bulk')
        ->middleware(['permission:update_accreditation']);

    Route::post('specializations', [SpecializationController::class, 'store'])
        ->name('specialization.store')
        ->middleware(['permission:create_specialization']);
    Route::get('specializations', [SpecializationController::class, 'index'])
        ->name('specializations.index')
        ->middleware(['permission:read_specialization']);
    Route::get('specializations/{specialization}', [SpecializationController::class, 'show'])
        ->name('specialization.show')
        ->middleware(['permission:read_specialization']);
    Route::put('specializations/{specialization}', [SpecializationController::class, 'update'])
        ->name('specialization.update')
        ->middleware(['permission:update_specialization']);
    Route::delete('specializations/{specialization}', [SpecializationController::class, 'delete'])
        ->name('specialization.delete')
        ->middleware(['permission:delete_specialization']);
    Route::post('specializations/bulk-create', [SpecializationController::class, 'bulkStore'])
        ->name('specialization.store.bulk')
        ->middleware(['permission:create_specialization']);
    Route::post('specializations/bulk-update', [SpecializationController::class, 'bulkUpdate'])
        ->name('specialization.update.bulk')
        ->middleware(['permission:update_specialization']);

    Route::post('designations', [DesignationController::class, 'store'])
        ->name('designation.store')
        ->middleware(['permission:create_designation']);
    Route::get('designations', [DesignationController::class, 'index'])
        ->name('designations.index')
        ->middleware(['permission:read_designation']);
    Route::get('designations/{designation}', [DesignationController::class, 'show'])
        ->name('designation.show')
        ->middleware(['permission:read_designation']);
    Route::put('designations/{designation}', [DesignationController::class, 'update'])
        ->name('designation.update')
        ->middleware(['permission:update_designation']);
    Route::delete('designations/{designation}', [DesignationController::class, 'delete'])
        ->name('designation.delete')
        ->middleware(['permission:delete_designation']);
    Route::post('designations/bulk-create', [DesignationController::class, 'bulkStore'])
        ->name('designation.store.bulk')
        ->middleware(['permission:create_designation']);
    Route::post('designations/bulk-update', [DesignationController::class, 'bulkUpdate'])
        ->name('designation.update.bulk')
        ->middleware(['permission:update_designation']);

    Route::post('hospitals', [HospitalController::class, 'store'])
        ->name('hospital.store')
        ->middleware(['permission:create_hospital']);
    Route::get('hospitals', [HospitalController::class, 'index'])
        ->name('hospitals.index')
        ->middleware(['permission:read_hospital']);
    Route::get('hospitals/{hospital}', [HospitalController::class, 'show'])
        ->name('hospital.show')
        ->middleware(['permission:read_hospital']);
    Route::put('hospitals/{hospital}', [HospitalController::class, 'update'])
        ->name('hospital.update')
        ->middleware(['permission:update_hospital']);
    Route::delete('hospitals/{hospital}', [HospitalController::class, 'delete'])
        ->name('hospital.delete')
        ->middleware(['permission:delete_hospital']);
    Route::post('hospitals/bulk-create', [HospitalController::class, 'bulkStore'])
        ->name('hospital.store.bulk')
        ->middleware(['permission:create_hospital']);
    Route::post('hospitals/bulk-update', [HospitalController::class, 'bulkUpdate'])
        ->name('hospital.update.bulk')
        ->middleware(['permission:update_hospital']);

    Route::post('patient-details', [PatientDetailsController::class, 'store'])
        ->name('patientDetails.store')
        ->middleware(['permission:create_patientdetails']);
    Route::get('patient-details', [PatientDetailsController::class, 'index'])
        ->name('patient-details.index')
        ->middleware(['permission:read_patientdetails']);
    Route::get('patient-details/{patientDetails}', [PatientDetailsController::class, 'show'])
        ->name('patientDetails.show')
        ->middleware(['permission:read_patientdetails']);
    Route::put('patient-details/{patientDetails}', [PatientDetailsController::class, 'update'])
        ->name('patientDetails.update')
        ->middleware(['permission:update_patientdetails']);
    Route::delete('patient-details/{patientDetails}', [PatientDetailsController::class, 'delete'])
        ->name('patientDetails.delete')
        ->middleware(['permission:delete_patientdetails']);
    Route::post('patient-details/bulk-create', [PatientDetailsController::class, 'bulkStore'])
        ->name('patientDetails.store.bulk')
        ->middleware(['permission:create_patientdetails']);
    Route::post('patient-details/bulk-update', [PatientDetailsController::class, 'bulkUpdate'])
        ->name('patientDetails.update.bulk')
        ->middleware(['permission:update_patientdetails']);

    Route::post('patient-family-details', [PatientFamilyDetailsController::class, 'store'])
        ->name('patientFamilyDetails.store')
        ->middleware(['permission:create_patientfamilydetails']);
    Route::get('patient-family-details', [PatientFamilyDetailsController::class, 'index'])
        ->name('patient-family-details.index')
        ->middleware(['permission:read_patientfamilydetails']);
    Route::get('patient-family-details/{patientFamilyDetails}', [PatientFamilyDetailsController::class, 'show'])
        ->name('patientFamilyDetails.show')
        ->middleware(['permission:read_patientfamilydetails']);
    Route::put('patient-family-details/{patientFamilyDetails}', [PatientFamilyDetailsController::class, 'update'])
        ->name('patientFamilyDetails.update')
        ->middleware(['permission:update_patientfamilydetails']);
    Route::delete('patient-family-details/{patientFamilyDetails}', [PatientFamilyDetailsController::class, 'delete'])
        ->name('patientFamilyDetails.delete')
        ->middleware(['permission:delete_patientfamilydetails']);
    Route::post('patient-family-details/bulk-create', [PatientFamilyDetailsController::class, 'bulkStore'])
        ->name('patientFamilyDetails.store.bulk')
        ->middleware(['permission:create_patientfamilydetails']);
    Route::post('patient-family-details/bulk-update', [PatientFamilyDetailsController::class, 'bulkUpdate'])
        ->name('patientFamilyDetails.update.bulk')
        ->middleware(['permission:update_patientfamilydetails']);

    Route::post('qualifications', [QualificationController::class, 'store'])
        ->name('qualification.store')
        ->middleware(['permission:create_qualification']);
    Route::get('qualifications', [QualificationController::class, 'index'])
        ->name('qualifications.index')
        ->middleware(['permission:read_qualification']);
    Route::get('qualifications/{qualification}', [QualificationController::class, 'show'])
        ->name('qualification.show')
        ->middleware(['permission:read_qualification']);
    Route::put('qualifications/{qualification}', [QualificationController::class, 'update'])
        ->name('qualification.update')
        ->middleware(['permission:update_qualification']);
    Route::delete('qualifications/{qualification}', [QualificationController::class, 'delete'])
        ->name('qualification.delete')
        ->middleware(['permission:delete_qualification']);
    Route::post('qualifications/bulk-create', [QualificationController::class, 'bulkStore'])
        ->name('qualification.store.bulk')
        ->middleware(['permission:create_qualification']);
    Route::post('qualifications/bulk-update', [QualificationController::class, 'bulkUpdate'])
        ->name('qualification.update.bulk')
        ->middleware(['permission:update_qualification']);

    Route::post('doctors', [DoctorController::class, 'store'])
        ->name('doctor.store')
        ->middleware(['permission:create_doctor']);
    Route::get('doctors', [DoctorController::class, 'index'])
        ->name('doctors.index')
        ->middleware(['permission:read_doctor']);
    Route::get('doctors/{doctor}', [DoctorController::class, 'show'])
        ->name('doctor.show')
        ->middleware(['permission:read_doctor']);
    Route::put('doctors/{doctor}', [DoctorController::class, 'update'])
        ->name('doctor.update')
        ->middleware(['permission:update_doctor']);
    Route::delete('doctors/{doctor}', [DoctorController::class, 'delete'])
        ->name('doctor.delete')
        ->middleware(['permission:delete_doctor']);
    Route::post('doctors/bulk-create', [DoctorController::class, 'bulkStore'])
        ->name('doctor.store.bulk')
        ->middleware(['permission:create_doctor']);
    Route::post('doctors/bulk-update', [DoctorController::class, 'bulkUpdate'])
        ->name('doctor.update.bulk')
        ->middleware(['permission:update_doctor']);
});

Route::get('past-queries', [PastQueryController::class, 'index'])
    ->name('past-queries.index');
Route::get('past-queries/{pastQuery}', [PastQueryController::class, 'show'])
    ->name('pastQuery.show');
Route::post('past-queries', [PastQueryController::class, 'store'])
    ->name('pastQuery.store');
Route::put('past-queries/{pastQuery}', [PastQueryController::class, 'update'])
    ->name('pastQuery.update');
Route::delete('past-queries/{pastQuery}', [PastQueryController::class, 'delete'])
    ->name('pastQuery.delete');
Route::post('past-queries/bulk-create', [PastQueryController::class, 'bulkStore'])
    ->name('pastQuery.store.bulk');
Route::post('past-queries/bulk-update', [PastQueryController::class, 'bulkUpdate'])
    ->name('pastQuery.update.bulk');
Route::get('active-queries', [ActiveQueryController::class, 'index'])
    ->name('active-queries.index');
Route::get('active-queries/{activeQuery}', [ActiveQueryController::class, 'show'])
    ->name('activeQuery.show');
Route::post('active-queries', [ActiveQueryController::class, 'store'])
    ->name('activeQuery.store');
Route::put('active-queries/{activeQuery}', [ActiveQueryController::class, 'update'])
    ->name('activeQuery.update');
Route::delete('active-queries/{activeQuery}', [ActiveQueryController::class, 'delete'])
    ->name('activeQuery.delete');
Route::post('active-queries/bulk-create', [ActiveQueryController::class, 'bulkStore'])
    ->name('activeQuery.store.bulk');
Route::post('active-queries/bulk-update', [ActiveQueryController::class, 'bulkUpdate'])
    ->name('activeQuery.update.bulk');
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
Route::post('confirmed-queries/bulk-create', [ConfirmedQueryController::class, 'bulkStore'])
    ->name('confirmedQuery.store.bulk');
Route::post('confirmed-queries/bulk-update', [ConfirmedQueryController::class, 'bulkUpdate'])
    ->name('confirmedQuery.update.bulk');
Route::get('patient-families', [PatientFamilyController::class, 'index'])
    ->name('patient-families.index');
Route::get('patient-families/{patientFamily}', [PatientFamilyController::class, 'show'])
    ->name('patientFamily.show');
Route::post('patient-families', [PatientFamilyController::class, 'store'])
    ->name('patientFamily.store');
Route::put('patient-families/{patientFamily}', [PatientFamilyController::class, 'update'])
    ->name('patientFamily.update');
Route::delete('patient-families/{patientFamily}', [PatientFamilyController::class, 'delete'])
    ->name('patientFamily.delete');
Route::post('patient-families/bulk-create', [PatientFamilyController::class, 'bulkStore'])
    ->name('patientFamily.store.bulk');
Route::post('patient-families/bulk-update', [PatientFamilyController::class, 'bulkUpdate'])
    ->name('patientFamily.update.bulk');
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