<?php

namespace App\Repositories;

use App\Models\Treatment;

class TreatmentRepository extends BaseRepository
{
    /**
     * @var string[]
     */
    protected $fieldSearchable = [
        'id',
        'name',
        'price',
        'images',
        'days_required',
        'recovery_time',
        'success_rate',
        'covered',
        'not_covered',
        'is_active',
        'created_at',
        'updated_at',
        'added_by',
        'updated_by',
    ];

    /**
     * @return string[]
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * @return string
     */
    public function model(): string
    {
        return Treatment::class;
    }

    /**
     * @return string[]
     */
    public function getAvailableRelations(): array
    {
        return ['addedByUser', 'updatedByUser', 'hospitalTreatments', 'doctorTreatments', 'specializationTreatments'];
    }
}
