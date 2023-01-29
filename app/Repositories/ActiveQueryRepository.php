<?php

namespace App\Repositories;

use App\Models\ActiveQuery;

class ActiveQueryRepository extends BaseRepository
{
    /**
     * @var string[]
     */
    protected $fieldSearchable = [
        'id',
        'query_id',
        'doctor_response',
        'patient_response',
        'attendant_passport',
        'tickets',
        'medical_visa',
        'is_payment_required',
        'is_payment_done',
        'country',
        'state',
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
        return ActiveQuery::class;
    }

    /**
     * @return string[]
     */
    public function getAvailableRelations(): array
    {
        return ['addedByUser', 'updatedByUser'];
    }
}
