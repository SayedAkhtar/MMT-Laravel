<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $permissions = [
            'create_qualification',
            'read_qualification',
            'update_qualification',
            'delete_qualification',
            'create_degisnation',
            'read_degisnation',
            'update_degisnation',
            'delete_degisnation',
            'create_doctor',
            'read_doctor',
            'update_doctor',
            'delete_doctor',
            'create_role',
            'read_role',
            'update_role',
            'delete_role',
            'create_user',
            'read_user',
            'update_user',
            'delete_user',
            'manage_roles'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
