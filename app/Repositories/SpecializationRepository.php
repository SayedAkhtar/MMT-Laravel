<?php

namespace App\Repositories;

use App\Models\Specialization;

class SpecializationRepository extends BaseRepository
{
    /**
     * @var  string[]
     */
    protected $fieldSearchable = [
        'id',
        'name',
        'logo',
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
        return Specialization::class;
    }


    /**
     * @return  string[]
     */
    public function getAvailableRelations(): array
    {
        return ['addedByUser', 'updatedByUser', 'pastQueries', 'specializations', 'specializationTreatments', 'query', 'patientDetails'];
    }
}
