<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DefaultUserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return  void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $inputUser = [
            'name' => $faker->word,
            'username' => $faker->word,
            'phone' => $faker->numberBetween(1,5),
            'is_active' => $faker->boolean(true),
            'created_at' => $faker->dateTime(),
            'updated_at' => $faker->dateTime(),
            'image' => $faker->word,
            'gender' => $faker->word,
            'country' => $faker->word,
            'dob' => $faker->date(),
            'email' => 'junior14@hotmail.com',
            'password' => Hash::make('C_plfAwdVz9nQCb'),
            'email_verified_at' => Carbon::now(),
            'user_type' => User::TYPE_USER
        ];

        $userUser  = User::create($inputUser);
        $roleUser  = Role::whereName('User')->first();
        $userUser->assignRole($roleUser);

        $inputAdmin = [
            'name' => $faker->word,
            'username' => $faker->word,
            'phone' => $faker->numberBetween(1,5),
            'is_active' => $faker->boolean(true),
            'created_at' => $faker->dateTime(),
            'updated_at' => $faker->dateTime(),
            'image' => $faker->word,
            'gender' => $faker->word,
            'country' => $faker->word,
            'dob' => $faker->date(),
            'email' => 'albina19@hotmail.com',
            'password' => Hash::make('ya4dEFBaqYvp1ar'),
            'email_verified_at' => Carbon::now(),
            'user_type' => User::TYPE_ADMIN
        ];

        $userAdmin  = User::create($inputAdmin);
        $roleAdmin  = Role::whereName('Admin')->first();
        $userAdmin->assignRole($roleAdmin);

        $roleSystemUser  = Role::whereName(User::DEFAULT_ROLE)->first();
        $inputSystemUser = [
            'name' => $faker->word,
            'phone' => $faker->numberBetween(1,5),
            'is_active' => $faker->boolean(true),
            'created_at' => $faker->dateTime(),
            'updated_at' => $faker->dateTime(),
            'image' => $faker->word,
            'gender' => $faker->word,
            'country' => $faker->word,
            'dob' => $faker->date(),
            'username' => 'morris07',
            'email' => 'elwyn01@reichel.biz',
            'password' => Hash::make('eX?dqNk?E'),
            'email_verified_at' => Carbon::now(),
            'user_type' => User::TYPE_ADMIN
        ];

        $systemUser = User::create($inputSystemUser);
        $systemUser->assignRole($roleSystemUser);

        $permissions = Permission::all();
        $roleSystemUser->givePermissionTo($permissions);
    }
}
