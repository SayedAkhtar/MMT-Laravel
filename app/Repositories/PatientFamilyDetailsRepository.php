<?php

namespace App\Repositories;

use App\Models\PatientFamilyDetails;

class PatientFamilyDetailsRepository extends BaseRepository
{
    /**
    * @var  string[]
    */
    protected $fieldSearchable = [
        'id',
        'patient_id',
        'name',
        'phone',
        'relationship',
        'dob',
        'gender',
        'geo_location',
        'treatment_country',
        'medical_info',
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
        return PatientFamilyDetails::class;
    }


    /**
     * @return  string[]
     */
    public function getAvailableRelations(): array
    {
       return ['addedByUser','updatedByUser','patientFamilies','user'];
    }
}