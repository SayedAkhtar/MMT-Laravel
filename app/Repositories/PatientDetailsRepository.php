<?php

namespace App\Repositories;

use App\Models\PatientDetails;

class PatientDetailsRepository extends BaseRepository
{
    /**
    * @var  string[]
    */
    protected $fieldSearchable = [
        'id',
        'user_id',
        'speciality',
        'treatment_country',
        'medical_ifo',
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
        return PatientDetails::class;
    }


    /**
     * @return  string[]
     */
    public function getAvailableRelations(): array
    {
       return ['addedByUser','updatedByUser','user''specialization'];
    }
}
