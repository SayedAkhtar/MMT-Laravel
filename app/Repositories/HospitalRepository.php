<?php

namespace App\Repositories;

use App\Models\Hospital;

class HospitalRepository extends BaseRepository
{
    /**
     * @var  string[]
     */
    protected $fieldSearchable = [
        'id',
        'name',
        'address',
        'description',
        'geo_location',
        'logo',
        'images',
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
        return Hospital::class;
    }


    /**
     * @return  string[]
     */
    public function getAvailableRelations(): array
    {
        return ['addedByUser', 'updatedByUser', 'queries', 'testimony', 'treatments', 'accreditation', 'doctors', 'tags'];
    }
}
