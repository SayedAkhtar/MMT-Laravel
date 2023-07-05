<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as PermissionModel;

class Permission extends PermissionModel
{
    public function __construct(array $attributes = [])
    {
        $attributes['guard_name'] = $attributes['guard_name'] ?? config('auth.defaults.guard');

        parent::__construct($attributes);
    }
}
