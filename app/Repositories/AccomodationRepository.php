<?php

namespace App\Repositories;

use App\Models\Accomodation;

class AccomodationRepository extends BaseRepository
{
    /**
    * @var  string[]
    */
    protected $fieldSearchable = [
        'id',
        'name',
        'address',
        'images',
        'type',
        'geo_location',
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
        return Accomodation::class;
    }


    /**
     * @return  string[]
     */
    public function getAvailableRelations(): array
    {
       return ['addedByUser','updatedByUser','confirmedQuery''accomodationFacitities''accomodationType'];
    }
}
