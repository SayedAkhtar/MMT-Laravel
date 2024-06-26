<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    /**
    * @var  string[]
    */
    protected $fieldSearchable = [
        'id',
        'name',
        'username',
        'email',
        'phone',
        'email_verified_at',
        'is_active',
        'created_at',
        'updated_at',
        'added_by',
        'updated_by',
        'image',
        'gender',
        'country',
        'dob',
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
        return User::class;
    }


    /**
     * @return  string[]
     */
    public function getAvailableRelations(): array
    {
       return ['addedByUser','updatedByUser','pastQuery','confirmedQuery','patientQuery','patientFamilyQuery','doctorQuery','patientTestimony','doctorTestimony','doctor','patientFamilies','patientDetails','patientFamilyDetails'];
    }
}