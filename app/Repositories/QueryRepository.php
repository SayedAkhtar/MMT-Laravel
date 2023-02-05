<?php

namespace App\Repositories;

use App\Models\Query;

class QueryRepository extends BaseRepository
{
    /**
    * @var  string[]
    */
    protected $fieldSearchable = [
        'id',
        'patient_id',
        'patient_family_id',
        'name',
        'specialization_id',
        'hospital_id',
        'doctor_id',
        'medical_history',
        'preffered_country',
        'medical_report',
        'passport',
        'passport_image',
        'status',
        'model',
        'model_id',
        'is_active',
        'created_at',
        'updated_at',
        'added_by',
        'updated_by',
        'is_completed',
        'completed_at',
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
        return Query::class;
    }


    /**
     * @return  string[]
     */
    public function getAvailableRelations(): array
    {
       return ['addedByUser','updatedByUser','pastQueries','confirmedQuery','user','patientFamily','specialization','hospital','doctor'];
    }
}