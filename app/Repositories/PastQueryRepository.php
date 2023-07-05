<?php

namespace App\Repositories;

use App\Models\PastQuery;

class PastQueryRepository extends BaseRepository
{
    /**
    * @var  string[]
    */
    protected $fieldSearchable = [
        'id',
        'user_id',
        'opening_date',
        'closing_date',
        'specialization_id',
        'is_active',
        'created_at',
        'updated_at',
        'added_by',
        'updated_by',
        'query_id',
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
        return PastQuery::class;
    }


    /**
     * @return  string[]
     */
    public function getAvailableRelations(): array
    {
       return ['addedByUser','updatedByUser','user','specialization','query'];
    }
}