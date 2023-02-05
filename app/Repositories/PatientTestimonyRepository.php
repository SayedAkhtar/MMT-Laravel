<?php

namespace App\Repositories;

use App\Models\PatientTestimony;

class PatientTestimonyRepository extends BaseRepository
{
    /**
    * @var  string[]
    */
    protected $fieldSearchable = [
        'id',
        'patient_id',
        'hospital_id',
        'doctor_id',
        'description',
        'images',
        'videos',
        'is_active',
        'created_at',
        'updated_at',
        'added_by',
        'updated_by',
    ];

    /**
    * @return  string[]
    */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
    * @return  string
    */
    public function model(): string
    {
        return PatientTestimony::class;
    }


    /**
     * @return  string[]
     */
    public function getAvailableRelations(): array
    {
       return ['addedByUser','updatedByUser','doctorPatientTestimonials','patientTestimonyTags''user','hospital','user'];
    }
}
