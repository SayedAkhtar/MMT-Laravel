<?php

namespace App\Repositories;

use App\Models\ConfirmedQuery;

class ConfirmedQueryRepository extends BaseRepository
{
    /**
     * @var string[]
     */
    protected $fieldSearchable = [
        'id',
        'query_id',
        'accomodation_id',
        'cab_detail',
        'coordinator_id',
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
        return ConfirmedQuery::class;
    }

    /**
     * @return string[]
     */
    public function getAvailableRelations(): array
    {
        return ['addedByUser', 'updatedByUser', 'query', 'accomodation', 'user'];
    }
}
